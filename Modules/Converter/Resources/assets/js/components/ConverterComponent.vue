<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form>
                <div class="mb-4">
                    <input class="form-control form-control-md"
                    :class="{'is-valid' : isValid === true, 'is-invalid' : isValid === false}" type="file" @change="onChange">
                    <div class="invalid-feedback">Выберите корректный файл .docx</div>
                </div>
            </form>

            <div v-if="templateKeys">
                <div
                    v-for="label in templateKeys"
                    :key="label"
                    class="mt-4">

                    <label class="form-label">{{ label }}</label>
                    <div class="input-group">
                        <input
                            v-model="templateValues[label]"
                            type="text"
                            class="form-control">
                    </div>
                </div>

                <div class="text-center">
                    <button
                        type="submit"
                        class="btn btn-primary mt-4"
                        @click.prevent="generatePdf"
                        >Сгенерировать PDF</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref } from "vue";

export default defineComponent({
  name: "ConverterComponent",
  setup() {
      const id = ref(null);
      const isValid = ref(null);
      const templateName = ref(null);
      const templateKeys = ref(null);
      const templateValues = ref([]);

      const onChange = (e) => {
          if (!e.target.files[0]) {
              isValid.value = null;
              clearParams();
              return false;
          }

          let file = e.target.files[0];
          console.log(file);
          checkValidation(file);

          if (isValid.value === true) {
              upload(file);
          } else {
              clearParams();
          }
      };

      const clearParams = () => {
          templateName.value = null;
          templateKeys.value = null;
          templateValues.value = [];
      };

      const apiClient = axios.create({
          baseURL: "api/",
          withCredentials: false,
          headers: {
              // Accept: "application/json",
              "Content-Type": "multipart/form-data",
          },
      });

      const upload = (file) => {
          console.log('upload');
          let formData = new FormData();
          formData.append('name', file.name);
          formData.append('file', file, 'filename.docx');

          apiClient.post('converter/upload', formData)
            .then((response) => {
                templateName.value = response.data.templateInfo.name;
                templateKeys.value = response.data.templateInfo.labels;
                templateValues.value = [];
                // console.log(response);
            }).catch((error) => {
                templateName.value = null;
                templateKeys.value = null;
                templateValues.value = [];
                console.log(error);
            })
      };

      const generatePdf = () => {
          // console.log(templateValues.value);
          let formData = new FormData();
          templateKeys.value.forEach(item => {
              formData.append(item, templateValues.value[item]);
          });
          formData.append('template', templateName.value);

          apiClient.post('converter/pdf', formData)
            .then((response) => {
                // console.log(response);
                window.open(response.data.link, '_blank').focus();
            }).catch((error) => {
                console.log(error);
            })
      };

      const checkValidation = (file) => {
          if (isValidExtention(file) && isValidType(file)) {
              isValid.value = true;
          } else {
              isValid.value = false;
          }
      };

      const isValidExtention = (file) => {
          return file.name.slice(-5) === '.docx';
      };

      const isValidType = (file) => {
          return file.type === "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
      };

      return {
          isValid,
          onChange,
          templateValues,
          templateKeys,
          templateName,
          generatePdf
      };
  },
  components: {},
});
</script>

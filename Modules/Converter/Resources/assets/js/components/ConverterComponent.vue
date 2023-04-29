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

                    <label class="form-label"><b>{{ label }}</b></label>
                    <div class="input-group">
                        <input
                            v-model="templateValues[label]"
                            type="text"
                            class="form-control">
                    </div>
                </div>

                <div class="text-center">
                    <button
                        v-if="buttonDisabled"
                        type="button"
                        class="btn btn-primary mt-4"
                        disabled
                        >
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Создаём PDF...
                    </button>
                    <button
                        v-else
                        type="button"
                        class="btn btn-primary mt-4"
                        @click.prevent="generatePdf"
                        >
                        Сгенерировать PDF
                    </button>
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
      const timerId = ref(null);
      const pdfLink = ref(false);
      const buttonDisabled = ref(false);

      const onChange = (e) => {
          if (!e.target.files[0]) {
              isValid.value = null;
              clearParams();
              return false;
          }

          let file = e.target.files[0];
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
          timerId.value = null;
          pdfLink.value = false;
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
          let formData = new FormData();
          formData.append('name', file.name);
          formData.append('file', file, 'filename.docx');

          apiClient.post('converter/upload', formData)
            .then((response) => {
                templateName.value = response.data.templateInfo.name;
                templateKeys.value = response.data.templateInfo.labels;
                templateValues.value = [];
            }).catch((error) => {
                templateName.value = null;
                templateKeys.value = null;
                templateValues.value = [];
                console.log(error);
            });
      };

      const generatePdf = () => {
          buttonDisabled.value = true;
          let formData = new FormData();
          templateKeys.value.forEach(item => {
              formData.append(item, templateValues.value[item]);
          });
          formData.append('template', templateName.value);

          apiClient.post('converter/pdf', formData)
            .then((response) => {
                runPdfChecker(response.data.filename);
            }).catch((error) => {
                console.log(error);
            })
      };

      const getPdfLink = (filename) => {
          apiClient.get('converter/pdf-link/by-name/' + filename)
            .then((response) => {
                if (response.data.link === '') {
                    runPdfChecker(filename);
                } else {
                    stopPdfChecker();
                    window.open(response.data.link, '_blank').focus();
                }
            }).catch((error) => {
                console.log(error);
            });
      };

      const runPdfChecker = (filename) => {
          timerId.value = setTimeout(getPdfLink, 2000, filename);
      };

      const stopPdfChecker = () => {
          console.log('stopPdfChecker');
          buttonDisabled.value = false;
          clearTimeout(timerId.value);
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
          buttonDisabled,
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

Добавьте ASSET_URL в файл .env

Надо создать папки:

/storage/app/temp/docs

/storage/app/temp/html

/storage/app/temp/templates

/storage/app/public/temp/pdf

Если внесли изменения в компонент Vue в модуле Converter, то выполняем:

cd Modules\\Converter

npm run build

Это демонстрационная версия. Здесь нет удаления промежуточных файлов (шаблон, сгенерированный docx, html). Надо дописать

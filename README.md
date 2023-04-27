git clone https://github.com/akxz/word2pdf.git

cd word2pdf

cp .env.example .env

php artisan key:generate

Добавляем ASSET_URL в файл .env

Для корректной работы должны существовать папки:

/storage/app/temp/docs

/storage/app/temp/html

/storage/app/temp/templates

/storage/app/public/temp/pdf

/public/storage/temp/pdf

Если внесли изменения в компонент Vue в модуле Converter, то выполняем:

cd Modules\\Converter

npm run build

Это демонстрационная версия. Здесь нет удаления промежуточных файлов (шаблон, сгенерированный docx, html). Надо дописать

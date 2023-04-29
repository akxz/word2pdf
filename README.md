git clone https://github.com/akxz/word2pdf.git

cd word2pdf

composer install

cp .env.example .env

php artisan key:generate

Добавляем ASSET_URL в файл .env

Для корректной работы должны существовать папки:

/storage/app/temp/docx

/storage/app/temp/templates

/public/storage/temp/pdf

/storage/app/public/temp/pdf

cd Modules\\Converter

npm install

Если внесли изменения в компонент Vue в модуле Converter, то:

cd Modules\\Converter

npm run build

Это демонстрационная версия. Здесь нет удаления промежуточных файлов (шаблон, сгенерированный docx)

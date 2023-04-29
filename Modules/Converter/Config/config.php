<?php

return [
    'name' => 'Converter',
    'template_dir' => env('CONVERTER_TEMPLATE_DIR', 'temp/templates/'),
    'docx_dir' => env('CONVERTER_DOCX_DIR', 'app/temp/docx/'),
    'public_pdf_dir' => env('CONVERTER_PUBLIC_PDF_DIR', 'storage/temp/pdf/'),
];

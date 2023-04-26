<?php

namespace Modules\Converter\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Converter\Http\Requests\UploadTemplateRequest;
use Modules\Converter\Http\Requests\GeneratePdfRequest;
use Modules\Converter\Actions\UploadTemplateAction;
use Modules\Converter\Actions\ParseTemplateVariablesByPathAction;
use Modules\Converter\Actions\GeneratePdfAndGetDownloadUrlAction;

class ConverterController extends Controller
{
    public function upload(UploadTemplateRequest $request)
    {
        $templateInfo = app(UploadTemplateAction::class)
            ->run($request->file('file'));

        return response()->json(compact('templateInfo'));
    }

    public function generatePdf(GeneratePdfRequest $request)
    {
        $link = app(GeneratePdfAndGetDownloadUrlAction::class)
            ->run($request->all());

        return response()->json(compact('link'));
    }
}

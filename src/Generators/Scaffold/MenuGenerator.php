<?php

namespace Jeffersonmartin\Buildhat\Generators\Scaffold;

use Illuminate\Support\Str;
use Jeffersonmartin\Buildhat\Common\CommandData;
use Jeffersonmartin\Buildhat\Generators\BaseGenerator;

class MenuGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $templateType;

    /** @var string */
    private $menuContents;

    /** @var string */
    private $menuTemplate;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = config(
            'buildhat.path.views',
            base_path('resources/views/'
            )
        ).$commandData->getAddOn('menu.menu_file');
        $this->templateType = config('buildhat.templates', 'adminlte-templates');

        $this->menuContents = file_get_contents($this->path);

        $this->menuTemplate = get_template('scaffold.layouts.menu_template', $this->templateType);

        $this->menuTemplate = fill_template($this->commandData->dynamicVars, $this->menuTemplate);
    }

    public function generate()
    {
        $this->menuContents .= $this->menuTemplate.buildhat_nl();

        file_put_contents($this->path, $this->menuContents);
        $this->commandData->commandComment("\n".$this->commandData->config->mCamelPlural.' menu added.');
    }

    public function rollback()
    {
        if (Str::contains($this->menuContents, $this->menuTemplate)) {
            file_put_contents($this->path, str_replace($this->menuTemplate, '', $this->menuContents));
            $this->commandData->commandComment('menu deleted');
        }
    }
}

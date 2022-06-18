<?php

namespace rahpt\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Modules extends BaseCommand
{
    /**
     * Group
     *
     * @var string
     */
    protected $group = 'CommandEx';

    /**
     * Command's name
     *
     * @var string
     */
    protected $name = 'module:create';

    /**
     * Command description
     *
     * @var string
     */
    protected $description = 'Create CodeIgniter4 Modules structure';

    /**
     * Command usage
     *
     * @var string
     */
    protected $usage = 'module:create [ModuleName] [Options]';

    /**
     * @param array $params
     * @return void
     */
    public function CreateModuleFolder(array $params): void
    {
        $this->module_name = ucfirst($this->module_name);

        $module_folder = preg_replace('/[^A-Za-z0-9]+/', '', $f ?? CLI::getOption('f'));
        $this->module_folderOrig = $module_folder ? ucfirst($module_folder) : basename(APPPATH) . DIRECTORY_SEPARATOR . 'Modules';
        $this->module_folder = APPPATH . '..' . DIRECTORY_SEPARATOR . $this->module_folderOrig;
        if (!is_dir($this->module_folder)) {
            mkdir($this->module_folder);
        }
        $this->module_folder = realpath($this->module_folder);

        CLI::write('Creating module ' . $this->module_folderOrig . DIRECTORY_SEPARATOR . $this->module_name);
        if (!is_dir($this->module_folder . DIRECTORY_SEPARATOR . $this->module_name)) {
            mkdir($this->module_folder . DIRECTORY_SEPARATOR . $this->module_name, 0777, true);
        }
    }

    /**
     * the Command's Arguments
     *
     * @var array
     */
    protected $arguments = ['ModuleName' => 'Module name to be created'];

    private function checkParams(array $params)
    {
        if (!isset($params[0])) {
            CLI::error("Module name must be set!. \n\nUsage:\n" . $this->usage);
            return;
        }

        $this->module_name = $params[0];

        if (strlen(preg_replace('/[^A-Za-z0-9]+/', '', $this->module_name)) <> mb_strlen($this->module_name)) {
            CLI::error("Module name must to be plain ascii characters A-Z or a-z, and can contain numbers 0-9");
            return;
        }
        return true;
    }

    public function run(array $params)
    {
        CLI::write('PHP Version: ' . CLI::color(PHP_VERSION, 'yellow'));
        CLI::write('CI Version: ' . CLI::color(\CodeIgniter\CodeIgniter::CI_VERSION, 'yellow'));
        CLI::write('APPPATH: ' . CLI::color(APPPATH, 'yellow'));
        CLI::write('SYSTEMPATH: ' . CLI::color(SYSTEMPATH, 'yellow'));
        CLI::write('ROOTPATH: ' . CLI::color(ROOTPATH, 'yellow'));
        CLI::write('BASEURL: ' . CLI::color(APP_BASE_URL, 'yellow'));
        CLI::write('Included files: ' . CLI::color(count(get_included_files()), 'yellow'));
    }
}
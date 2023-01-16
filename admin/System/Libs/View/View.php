<?php
/*************************************************
 * Titan-2 Mini Framework
 * View Library
 *
 * Author 	: Turan Karatuğ
 * Web 		: http://www.titanphp.com
 * Docs 	: http://kilavuz.titanphp.com
 * Github	: http://github.com/tkaratug/titan2
 * License	: MIT
 *
 *************************************************/
namespace System\Libs\View;

use Windwalker\Edge\Cache\EdgeFileCache;
use Windwalker\Edge\Edge;
use Windwalker\Edge\Exception\LayoutNotFoundException;
use Windwalker\Edge\Loader\EdgeFileLoader;

class View
{
	// Active Theme
	private $theme = null;

    private function renderControl($file, $vars = [], $cache = false)
    {
        $paths 	= [APP_DIR . 'Views'];

        $loader = new EdgeFileLoader($paths);
        $loader->addFileExtension('.blade.php');

        if ($cache === false)
            $edge = new Edge($loader);
        else
            $edge = new Edge($loader, null, new EdgeFileCache(APP_DIR . '/Storage/Cache'));

        if (is_null($this->theme))
            return $edge->render($file, $vars);
        else
            return $edge->render($this->theme . '.' . $file, $vars);
    }

	/**
	 * Render View File
	 *
	 * @param string $file
	 * @param array $vars
	 * @param boolean $cache
	 * @return void
	 */
	public function render($file, $vars = [], $cache = false)
	{
        echo $this->renderControl($file, $vars, $cache);
	}

    public function getRender($file, $vars = [], $cache = false)
    {
        return $this->renderControl($file, $vars, $cache);
    }

	/**
	 * Set Activated Theme
	 *
	 * @param string $theme
	 * @return $this
	 */
	public function theme($theme)
	{
		if (!file_exists(APP_DIR . 'Views/' . $theme))
            throw new \System\Libs\Exception\ExceptionHandler("Hata", "Tema dizini bulunamadı. { $theme }");

        $this->theme = $theme;

		return $this;
	}

    public function viewControl($key)
    {
        $key = str_replace('.', '/', $key);

        if (file_exists('App/Views/' . $key . '.edge.php')) {
            return true;
        } elseif(file_exists('App/Views/' . $key . '.blade.php')) {
            return true;
        } else {
            return false;
        }
    }
}

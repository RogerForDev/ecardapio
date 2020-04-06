<?php

namespace App\traits;

use App\src\Load;

trait View {

	protected $twig;

	protected function twig() {
		$loader = new \Twig_Loader_Filesystem('../app/views');

		$this->twig = new \Twig_Environment($loader, array(
			// 'cache' => '',
			'debug' => true,
		));
	}

	protected function functions() {
		$functions = Load::file('/app/functions/twig.php');

		foreach ($functions as $function) {
			$this->twig->addFunction($function);
		}
	}

	protected function extensions() {
		$this->twig->addExtension(new \Twig_Extensions_Extension_Text());
	}

	protected function load() {
		$this->twig();

		$this->functions();

		$this->extensions();
	}

	protected function view($view, $data) {
		$this->load();

		$template = $this->twig->loadTemplate(str_replace('.', '/', $view) . '.html');

		return $template->display($data);
	}

}
<?php

class extUserlistForm extends AbstractPage {
	
	public static function getSiteDisplayName() {
		return '<i class="fa fa-user-edit"></i> Benutzerliste - Neue Liste';
	}

	public function __construct($request = [], $extension = []) {
		parent::__construct(array( self::getSiteDisplayName() ), false, false, false, $request, $extension);
		$this->checkLogin();
	}


	public function execute() {

        //$_request = $this->getRequest();

        $acl = $this->getAcl();
        if ((int)$acl['rights']['read'] !== 1 && (int)DB::getSession()->getUser()->isAnyAdmin() !== 1) {
            new errorPage('Kein Zugriff');
        }

		$this->render([
			"tmpl" => "default",
            "scripts" => [
                PATH_EXTENSION.'tmpl/scripts/form/dist/main.js'
            ],
            "data" => [
                "apiURL" => "rest.php/userlist",
                "acl" => $acl['rights']
		    ]
        ]);

	}


}

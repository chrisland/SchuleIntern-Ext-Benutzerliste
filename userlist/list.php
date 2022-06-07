<?php

class extUserlistList extends AbstractPage {
	
	public static function getSiteDisplayName() {
		return '<i class="fas fa fa-user-check"></i> Benutzerliste - Liste';
	}

	public function __construct($request = [], $extension = []) {
		parent::__construct(array( self::getSiteDisplayName() ), false, false, false, $request, $extension);
		$this->checkLogin();
	}


	public function execute() {

        $_request = $this->getRequest();
        if ( !(int)$_request ) {
            new errorPage('Kein Zugriff [id]');
        }

        $acl = $this->getAcl();
        if ((int)$acl['rights']['read'] !== 1 && (int)DB::getSession()->getUser()->isAnyAdmin() !== 1 ) {
            new errorPage('Kein Zugriff');
        }

        $user = DB::getSession()->getUser();

        //print_r( $acl );

        $data = extUserlistModelList::getByID($_request['id'], $user->getUserID());

        $collection = $data->getCollection(true);

        $collection['owners'] = [];
        foreach($data->getOwners() as $user) {
            $collection['owners'][] = $user->getCollection();
        }

        $collection['members'] = [];
        foreach($data->getMembers() as $user) {
            $collection['members'][] = $user->getCollection();
        }

        $collection['stats'] = $data->getStatsMember();


		$this->render([
			"tmpl" => "default",
            "scripts" => [
                PATH_EXTENSION.'tmpl/scripts/list/dist/main.js'
            ],
            "data" => [
                "apiURL" => "rest.php/userlist",
                "acl" => $acl['rights'],
                "items" => $collection
		    ]
        ]);

	}


}

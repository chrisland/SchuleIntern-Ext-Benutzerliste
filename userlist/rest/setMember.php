<?php

class setMember extends AbstractRest {
	
	protected $statusCode = 200;


	public function execute($input, $request) {


        $userID = DB::getSession()->getUser()->getUserID();
        if (!$userID) {
            return [
                'error' => true,
                'msg' => 'Missing User ID'
            ];
        }
        $item_id = (int)$input['id'];

        if ( !$item_id  ) {
            //die('missing data');
            return [
                'error' => true,
                'msg' => 'Missing DataID'
            ];
        }

        $acl = $this->getAcl();
        if ((int)$acl['rights']['write'] !== 1 && (int)DB::getSession()->getUser()->isAnyAdmin() !== 1 ) {
            return [
                'error' => true,
                'msg' => 'Kein Zugriff'
            ];
        }



        if ($item_id > 0) {

            if ($input['toggle']) {
                if (!DB::getDB()->query("UPDATE ext_userlist_list_members
                SET toggle= " . DB::getDB()->escapeString($input['toggle']) . "
                WHERE id=".$item_id
                )) {
                    return [
                        'error' => true,
                        'msg' => 'Fehler beim Speichern!'
                    ];
                }
            }

            if ($input['info']) {
                if (!DB::getDB()->query("UPDATE ext_userlist_list_members
                SET info='" . DB::getDB()->escapeString($input['info']) . "'
                WHERE id=".$item_id
                )) {
                    return [
                        'error' => true,
                        'msg' => 'Fehler beim Speichern!'
                    ];
                }
            }



            return [
                'error' => false,
                'insert' => true
            ];

        }




        return [
			'error' => true,
			'msg' => 'Return Error!'
		];

	}


	/**
	 * Set Allowed Request Method
	 * (GET, POST, ...)
	 * 
	 * @return String
	 */
	public function getAllowedMethod() {
		return 'POST';
	}


    /**
     * Muss der Benutzer eingeloggt sein?
     * Ist Eine Session vorhanden
     * @return Boolean
     */
    public function needsUserAuth() {
        return true;
    }

    /**
     * Ist eine Admin berechtigung nötig?
     * only if : needsUserAuth = true
     * @return Boolean
     */
    public function needsAdminAuth()
    {
        return false;
    }
    /**
     * Ist eine System Authentifizierung nötig? (mit API key)
     * only if : needsUserAuth = false
     * @return Boolean
     */
    public function needsSystemAuth() {
        return false;
    }

}	

?>
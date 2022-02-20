<?php

class setList extends AbstractRest {
	
	protected $statusCode = 200;


	public function execute($input, $request) {


        $userID = DB::getSession()->getUser()->getUserID();
        if (!$userID) {
            return [
                'error' => true,
                'msg' => 'Missing User ID'
            ];
        }

        if (!$input['title'] || !$input['members']  ) {
            //die('missing data');
            return [
                'error' => true,
                'msg' => 'Missing Data'
            ];
        }

        $acl = $this->getAcl();
        if ((int)$acl['rights']['write'] !== 1 && (int)DB::getSession()->getUser()->isAnyAdmin() !== 1 ) {
            return [
                'error' => true,
                'msg' => 'Kein Zugriff'
            ];
        }



        if ((int)$input['id'] > 0) {

            /*
            if ((int)$acl['rights']['write'] !== 1 && (int)DB::getSession()->getUser()->isAnyAdmin() !== 1 ) {
                return [
                    'error' => true,
                    'msg' => 'Kein Zugriff (2)'
                ];
            }

            if (!DB::getDB()->query("UPDATE ext_sprechstunde_slots
                SET title='" . DB::getDB()->escapeString($input['title']) . "',
                time='" . $time_str . "',
                day='" . DB::getDB()->escapeString($input['day']) . "',
                duration='" . DB::getDB()->escapeString($input['duration']) . "',
                typ='" . $_POST['typ'] . "'
                WHERE id=".(int)$input['id']
            )) {
                return [
                    'error' => true,
                    'msg' => 'Fehler beim Hinzufügen!'
                ];
            }

            return [
                'error' => false,
                'insert' => true
            ];
*/
        } else {

            if (!DB::getDB()->query("INSERT INTO ext_userlist_list
				(
				    createdTime,
				    createdBy,
					title
				) values(
				    '".date('Y-m-d H:i', time())."',
				    ".$userID.",
					'" . DB::getDB()->escapeString($input['title']) . "'
				)
		    ")) {
                return [
                    'error' => true,
                    'msg' => 'Fehler beim Hinzufügen! (list)'
                ];
            }
            $insertID = DB::getDB()->insert_id();

            if (!(int)$insertID ) {
                return [
                    'error' => true,
                    'msg' => 'Fehler beim Hinzufügen! (insert)'
                ];
            }


            if ($_POST['owners']) {
                $owners = json_decode($_POST['owners']);
                if (!is_array($owners)) {
                    $owners = [];
                }
            } else {
                $owners = [];
            }
            $owners[] = $userID; // add self User
            if (count($owners) > 0) {
                foreach($owners as $owner) {
                    if ((int)$owner && !DB::getDB()->query("INSERT INTO ext_userlist_list_owner
                        (
                            list_id,
                            user_id
                        ) values(
                            ".$insertID.",
                            ".(int)$owner."
                        )
                    ")) {
                        return [
                            'error' => true,
                            'msg' => 'Fehler beim Hinzufügen! (list_user)'
                        ];
                    }
                }
            }

            $members = json_decode($_POST['members']);
            if (count($members) > 0) {
                foreach($members as $member) {
                    if ((int)$member && !DB::getDB()->query("INSERT INTO ext_userlist_list_members
                        (
                            list_id,
                            user_id
                        ) values(
                            ".$insertID.",
                            ".(int)$member."
                        )
                    ")) {
                        return [
                            'error' => true,
                            'msg' => 'Fehler beim Hinzufügen! (list_user)'
                        ];
                    }
                }
            }


            return [
                'error' => false,
                'insert' => true
            ];
        }






        return [
			'error' => true,
			'msg' => 'Return Data!'
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
<?php
//    grant all privileges on globe_bank.* to 'webuser'@'localhost' indentified by 'secretpassword';
//    import subjects and pages tables and data


    function validate_page($page){

        $errors = [];

        //menu name. appends error string in array
        if(is_blank($page['menu_name'])){
            $errors[] = "Name cannot be blank.";
        }
        //min max values dependent on database
        elseif(!has_length($page['menu_name'], ['min' => 2, 'max' => 255])){
            $errors[] = "Name must be between 2 and 255 characters.";
        }
//        $current_id = $page['id'] ?? '0';
//        if(!has_unique_page_menu_name($page['menu_name'], $current_id)){
//            $errors[] = "Menu name must be unique.";
//        }

        //subject id.
        if(is_blank($page['subject_id'])){
            $errors[] = "Subject cannot be blank.";
        }

        //position. Make sure we are working with an integer
        $position_int = (int) $page['position'];
        if($position_int <= 0){
            $errors[] = "Position must be greater than zero.";
        }
        if($position_int > 999){
            $errors[] = "Position must be less than 999";
        }

        //visible. Make sure we are working with a astrin
        $visible_str = (string) $page['visible'];
        if(!has_inclusion_of($visible_str, ["0","1"])){
            $errors[] = "Visible must be true or false.";
        }

        return $errors;
    }

    function find_all_users($options=[]){
        global $db;
        $collection = $db->test->users;
        $cursor = $collection->find(
            [],
            [
                'sort' => ['pop' => 1],
            ]);

        $visible = $options['visible'] ?? false;
//        $sql = "SELECT * FROM subjects ";
//        if($visible){
//            $sql .= "WHERE visible = true ";
//        }
//        $sql .= "ORDER BY position ASC";
//        $result = mysqli_query($db, $sql);
        confirm_result_set($cursor);
        return $cursor;
    }

    function find_all_pages(){
        global $db;
        $sql = "SELECT * FROM pages ";
        $sql .= "ORDER BY subject_id ASC, position ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_page_by_id($id, $options=[]){
        global $db;

        $visible = $options['visible'] ?? false;

        $sql = "SELECT * FROM pages ";
        $sql .= "WHERE id='" . db_escape($db,$id) . "' ";
        if($visible){
            $sql .= "AND visible = true ";
        }
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $page = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $page; //returns an assoc. array
    }

    function insert_page($page){
        global $db;

        $errors = validate_page($page);
        if(!empty($errors)){
            return $errors;
        }

        $sql = "INSERT INTO pages ";
        $sql .= "(subject_id, menu_name, position, visible, content) ";
        $sql .= "VALUES (";
        $sql .= "'" . $page['subject_id'] . "',";
        $sql .= "'" . $page['menu_name'] . "',";
        $sql .= "'" . $page['position'] . "',";
        $sql .= "'" . $page['visible'] . "',";
        $sql .= "'" . $page['content'] . "'";
        $sql .= ")";

        $result = mysqli_query($db, $sql);
        //for insert statements, $result is true/false
        if($result){
            return true;
        }
        else{
            //echo mysqli_error($db);
            //db_disconnect($db);
            //exit;

            $errors = (array) mysqli_error($db);
            return $errors;
        }
    }

    function update_page($page){
        global $db;

        $errors = validate_subject($page);
        if(!empty($errors)){
            return $errors;
        }

        $sql = "UPDATE pages SET ";
        $sql .= "subject_id='" . $page['subject_id'] . "',";
        $sql .= "menu_name='" . $page['menu_name'] . "',";
        $sql .= "position='" . $page['position'] . "',";
        $sql .= "visible='" . $page['visible'] . "',";
        $sql .= "content='" . $page['content'] . "' ";
        $sql .= "WHERE id='" . $page['id'] . "' ";
        $sql .= "LIMIT 1";

        $result = mysqli_query($db, $sql);
        //for insert statements, $result is true/false
        if($result){
            return true;
        }
        else{
            //echo mysqli_error($db);
            //db_disconnect($db);
            //exit;

            $errors = (array) mysqli_error($db);
            return $errors;
        }
    }

    function delete_page($id){
        global $db;

        $sql = "DELETE FROM pages ";
        $sql .= "WHERE id='" . $id . "' ";
        $sql .= "LIMIT 1";

        $result = mysqli_query($db, $sql);
        //for insert statements, $result is true/false
        if($result){
            return true;
        }
        else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
}

    function validate_subject($subject){

        $errors = [];

        //menu name. appends error string in array
        if(is_blank($subject['menu_name'])){
            $errors[] = "Name cannot be blank.";
        }
        //min max values dependent on database
        elseif(!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])){
            $errors[] = "Name must be between 2 and 255 characters.";
        }

        //position. Make sure we are working with an integer
        $position_int = (int) $subject['position'];
        if($position_int <= 0){
            $errors[] = "Position must be greater than zero.";
        }
        if($position_int > 999){
            $errors[] = "Position must be less than 999";
        }

        //visible. Make sure we are working with a astrin
        $visible_str = (string) $subject['visible'];
        if(!has_inclusion_of($visible_str, ["0","1"])){
            $errors[] = "Visible must be true or false.";
        }

        return $errors;
    }

    function find_subject_by_id($id, $options=[]){
        global $db;
        $visible = $options['visible'] ?? false;

        $sql = "SELECT * FROM subjects ";
        $sql .= "WHERE id='" . db_escape($db,$id) . "' ";
        if($visible){
            $sql .= "AND visible = true ";
        }
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $subject = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return$subject; //returns an assoc array.
    }

    function insert_subject($subject){
        global $db;

        $errors = validate_subject($subject);
        if(!empty($errors)){
            return $errors;
        }

        $sql = "INSERT INTO subjects ";
        $sql .= "(menu_name, position, visible) ";
        $sql .= "VALUES (";
        $sql .= "'" . db_escape($db,$subject['menu_name']) . "',";
        $sql .= "'" . db_escape($db,$subject['position']) . "',";
        $sql .= "'" . db_escape($db,$subject['visible']) . "'";
        $sql .= ")";

        $result = mysqli_query($db, $sql);
        //for insert statements, $result is true/false
        if($result){
            return true;
           }
        else{
            //insert failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_subject($subject){
        global $db;

        $errors = validate_subject($subject);
        if(!empty($errors)){
            return $errors;
        }

        $sql = "UPDATE subjects SET ";
        $sql .= "menu_name='" . db_escape($db,$subject['menu_name']) . "', ";
        $sql .= "position='" . db_escape($db,$subject['position']) . "', ";
        $sql .= "visible='" . db_escape($db,$subject['visible']) . "' ";
        $sql .= "WHERE id='" . db_escape($db,$subject['id']) . "' ";
        $sql .= "LIMIT 1";

        $result = mysqli_query($db, $sql);
        if($result){
           return true;
        }
        else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_subject($id){
        global $db;

        $sql = "DELETE FROM subjects ";
        $sql .= "WHERE id='" . db_escape($db,$id) . "' ";
        $sql .= "LIMIT 1";

        $result = mysqli_query($db, $sql);

        //for delete statements, $result is true/false
        if($result){
            return true;
        }
        else{
            //delete failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function find_pages_by_subject_id($subject_id, $options=[]){
        global $db;

        $visible = $options['visible'] ?? false;

        $sql = "SELECT * FROM pages ";
        $sql .= "WHERE subject_id='" . db_escape($db,$subject_id) . "' ";
        if($visible){
            $sql .= "AND visible = true ";
        }
        $sql .= "ORDER BY position ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result; //returns an assoc. array
    }

    //find all admins ordered by last name first name
    function find_all_admins($sort){
        global $db;

        $collection = $db->test->users;

        $cursor = $collection->find(
            [],
            [
                'sort' => [$sort => 1]
            ]);

//        $sql = "SELECT * FROM admins ";
//        $sql .= "ORDER BY last_name ASC, first_name ASC";
//        $result = mysqli_query($db, $sql);
        confirm_result_set($cursor);
        return $cursor;
    }

    function find_admin_by_id($id){
        global $db;

        $collection = $db->test->users;
        $cursor = $collection->findOne(['_id'=>(int)$id]);

//        $sql = "SELECT * FROM admins ";
//        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
//        $sql .= "LIMIT 1";
//        $result = mysqli_query($db, $sql);
        confirm_result_set($cursor);
//        $admin = mysqli_fetch_assoc($result);
//        mysqli_free_result($result);
        return $cursor;
    }

    function validate_admin($admin, $options=[]){

        $errors = [];

        $password_required = $options['password_required'] ?? true;

        if(is_blank($admin['name'])){
            $errors[] = "First name cannot be blank";
        }
        elseif(!has_length($admin['name'], array('min' => 2, 'max' => 255))){
            $errors[] = "First name must be between 2 and 155 characters";
        }

        if(is_blank($admin['surname'])){
            $errors[] = "Last name cannot be blank";
        }
        elseif(!has_length($admin['surname'], array('min' => 2, 'max' => 255))){
            $errors[] = "Last name must be between 2 and 155 characters";
        }

        if(is_blank($admin['email'])){
            $errors[] = "Email cannot be blank";
        }
        elseif(!has_length($admin['email'], array('max' => 255))){
            $errors[] = "Email must be between 2 and 155 characters";
        }
        elseif(!has_valid_email_format($admin['email'])){
            $errors[] = "Email must be a valid format";
        }

        if(is_blank($admin['username'])){
            $errors[] = "Username cannot be blank";
        }
        elseif(!has_length($admin['username'], array('min' => 8, 'max' => 255))){
            $errors[] = "Username must be between 8 and 155 characters";
        }
        elseif(!has_unique_username($admin['username'], $admin['id'] ?? 0)){
            $errors[] = "Username already in use. Try another.";
        }

        if($password_required){
            if(is_blank($admin['password'])) {
                $errors[] = "Password cannot be blank.";
            } elseif (!has_length($admin['password'], array('min' => 12))) {
                $errors[] = "Password must contain 12 or more characters";
            } elseif (!preg_match('/[A-Z]/', $admin['password'])) {
                $errors[] = "Password must contain at least 1 uppercase letter";
            } elseif (!preg_match('/[a-z]/', $admin['password'])) {
                $errors[] = "Password must contain at least 1 lowercase letter";
            } elseif (!preg_match('/[0-9]/', $admin['password'])) {
                $errors[] = "Password must contain at least 1 number";
            } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
                $errors[] = "Password must contain at least 1 symbol";
            }

            if(is_blank($admin['confirm_password'])) {
                $errors[] = "Confirm password cannot be blank.";
            } elseif ($admin['password'] !== $admin['confirm_password']) {
                $errors[] = "Password and confirm password must match.";
            }
        }
        return $errors;
    }

    function insert_admin($admin){
        global $db;

        $errors = validate_admin($admin);
        if(!empty($errors)){
            return $errors;
        }

        $hashed_password = password_hash($admin['password'], PASSWORD_DEFAULT);

        $collection = $db->test->users;

        $id = $collection->count() +1;

        $cursor = $collection->insertOne(
            [
                '_id' => $id,
                'name'=>$admin['name'],
                'surname'=>$admin['surname'],
                'email'=>$admin['email'],
                'username'=>$admin['username'],
                'password'=>$hashed_password
            ]
        );


//        $sql = "INSERT INTO admins  ";
//        $sql .= "(first_name, last_name, email, username, hashed_password) ";
//        $sql .= "VALUES (";
//        $sql .= "'" . db_escape($db,$admin['first_name']) . "',";
//        $sql .= "'" . db_escape($db,$admin['last_name']) . "',";
//        $sql .= "'" . db_escape($db,$admin['email']) . "',";
//        $sql .= "'" . db_escape($db,$admin['username']) . "',";
//        $sql .= "'" . db_escape($db,$hashed_password) . "'";
//        $sql .= ")";
//        $result = mysqli_query($db, $sql);

        //for insert statement result is true/false
        if($cursor){
            return true;
        }
        else{
            //insert failed
//            echo mysqli_error($db);
//            db_disconnect($db);
            exit;
        }
    }

    function update_admin($admin){
        global $db;

        //Returns !FALSE if var exists and has a non-empty, non-zero value. Otherwise returns !TRUE.
        //if no pass is typed, use current one
        $password_sent = !is_blank($admin['password']);

        $errors = validate_admin($admin, ['password_required' => $password_sent]);
        if(!empty($errors)){
            return $errors;
        }

        $hashed_password = password_hash($admin['password'], PASSWORD_DEFAULT);
        $collection = $db->test->users;

        $options = ['name' => $admin['name'],
                    'surname' => $admin['surname'],
                    'email' => $admin['email']];

        if($password_sent) {
            $options = array_merge($options, ['hashed_password' => $hashed_password]);
        }
        $options = array_merge($options, ['username' => $admin['username']]);

        $cursor = $collection->updateOne(
            ['_id' => $admin['_id']],
            ['$set' => $options]
        );


//        $sql = "UPDATE admins SET ";
//        $sql .= "first_name='" . db_escape($db,$admin['first_name']) . "',";
//        $sql .= "last_name='" . db_escape($db,$admin['last_name']) . "', ";
//        $sql .= "email='" . db_escape($db,$admin['email']) . "', ";
//        if($password_sent){
//            $sql .= "hashed_password='" . db_escape($db,$hashed_password) . "',";
//        }
//        $sql .= "username='" . db_escape($db,$admin['username']) . "' ";
//        $sql .= "WHERE id='" . db_escape($db,$admin['id']) . "' ";
//        $sql .= "LIMIT 1";
//        $result = mysqli_query($db, $sql);

        if($cursor){
            return true;
        }
        else{
//            echo mysqli_error($db);
//            db_disconnect($db);
            exit;
        }
    }

    function delete_admin($id){
        global $db;
        $connection = $db->test->users;
        $cursor = $connection->findOneAndDelete(['_id' => (int)$id]);

//        $sql = "DELETE FROM admins ";
//        $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
//        $sql .= "LIMIT 1;";
//        $result = mysqli_query($db, $sql);

        if($cursor){
            return true;
        }
        else{
//            echo mysqli_error($db);
//            db_disconnect($db);
            exit;
        }
    }

    function find_admin_by_username($username){
        global $db;
        $collection = $db->test->users;
        $cursor = $collection->findOne(
            [
                'username' => $username,
            ],
            [
                'username' => 1,
            ]);
//        $sql = "SELECT * FROM admins ";
//        $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
//        $sql .= "LIMIT 1";
//        $result = mysqli_query($db, $sql);
        confirm_result_set($cursor);
//        $admin = mysqli_fetch_assoc($result);
//        mysqli_free_result($result);
        return $cursor;
    }

    function last_insert_id(){
        global $db;
        $collection = $db->test->users;

        $id = $collection->count();

        confirm_result_set($id);

        return $id;
    }

    function total_orders(){
        global $db;
        $collection = $db->test->users;
        $result = $collection->find(['orders']['invoiceNumber']);
        var_dump($result);
    }
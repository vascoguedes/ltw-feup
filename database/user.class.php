<?php
  declare(strict_types = 1);

  class User {
    public int $id;
    public string $username;
    public string $address;
    public string $phone;
    public string $email;
    public string $birthdate;
    public string $emailVerification;
    public string $verificationToken;

    public function __construct(int $id, string $username, string $address, string $phone, string $email, string $birthdate, string $emailVerification, string $verificationToken)
    {
      $this->id = $id;
      $this->username = $username;
      $this->address = $address;
      $this->phone = $phone;
      $this->email = $email;
      $this->birthdate = $birthdate;
      $this->emailVerification = $emailVerification;
      $this->verificationToken = $verificationToken;

    }

    function userName() {
      return $this->username;
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE Customer SET Username = ?
        WHERE User_id = ?
      ');

      $stmt->execute(array($this->username, $this->id));
    }
    
    static function getUserWithPassword(PDO $db, string $email, string $password) : ?User {
      $stmt = $db->prepare('
        SELECT User_id, Username, Address, Phone_number, Email, Birthdate, EmailVerified, VerificationToken
        FROM User 
        WHERE lower(email) = ? AND password = ?
      ');

      $stmt->execute(array(strtolower($email), sha1($password)));
  
      if ($customer = $stmt->fetch()) {
        return new User(
          $customer['User_id'],
          $customer['Username'],
          $customer['Address'],
          $customer['Phone_number'],
          $customer['Email'],
          $customer['Birthdate'],
          $customer['EmailVerified'],
          $customer['VerificationToken']
        );
      } else return null;
    }

    static function getCustomer(PDO $db, int $id) : Customer {
      $stmt = $db->prepare('
        SELECT User_id, Username, Address, Phone_number, Email, Birthdate, EmailVerification, VerificationToken
        FROM User 
        WHERE User_id = ?
      ');

      $stmt->execute(array($id));
      $customer = $stmt->fetch();
      
      return new User(
          $customer['User_id'],
          $customer['Username'],
          $customer['Address'],
          $customer['Phone_number'],
          $customer['Email'],
          $customer['Birthdate'],
          $customer['EmailVerified'],
          $customer['VerificationToken']
      );
    }

    static function checkAvailability(PDO $db, string $Email, string $Username) : string {
      $stmt = $db->prepare('SELECT * FROM User where Email= :Email');
      $stmt->bindParam(':Email', $Email);
      $stmt->execute();

      $stmt1 = $db->prepare('SELECT * FROM User where Username= :Username');
      $stmt1->bindParam(':Username', $Username);
      $stmt1->execute();
      
      $users = $stmt->fetchAll();
      $users1 = $stmt1->fetchAll();

      if ($users && $users1) {
        return 'Email e username não disponíveis';
      } else if ($users) {
        return 'Email não disponível';
      } else if ($users1) {
        return 'Username não disponível';
      } else {
        return 'AVAILABLE';
      }
    }

    static function getUserIdAndPassword(PDO $db, string $email) : array {
      $stmt = $db->prepare('SELECT * FROM User where Email= :email');
      $stmt->bindParam(':email', $email);

      $stmt->execute();
      $user = $stmt->fetch();

      if ($user) {
        return [$user['User_id'], $user['EmailVerified'], $user['Password']];
      } else {
        return ['NULL'];
      }
    }

    static function getUserName(PDO $db, string $id) : string {
      $stmt = $db->prepare('SELECT Username FROM User where User_id= :id');
      $stmt->bindParam(':id', $id);

      $stmt->execute();
      $user = $stmt->fetch();
      
      return $user['Username'];
    }

    static function getUserProfileInfo(PDO $db, string $id) : Array {
      $stmt = $db->prepare('SELECT Username, Address, Email, Phone_number, Birthdate, Picture FROM User where User_id= :id');
      $stmt->bindParam(':id', $id);

      $stmt->execute();
      $user = $stmt->fetch();
      
      return $user;
    }

    static function generateNewToken(PDO $db) : string {
      
      while (true) {
        $VerificationToken = bin2hex(openssl_random_pseudo_bytes(32));
        $stmt = $db->prepare('SELECT Username FROM User where VerificationToken= :VerificationToken');
        $stmt->bindParam(':VerificationToken', $VerificationToken);

        $stmt->execute();
        $users = $stmt->fetchAll();

        if (!$users){
          return $VerificationToken;
        }
      }
    }

    static function getToken(PDO $db, string $Email) : string {
      
      $stmt = $db->prepare('SELECT VerificationToken FROM User where Email= :Email');
      $stmt->bindParam(':Email', $Email);

      $stmt->execute();
      $token = $stmt->fetch();

      if ($token['VerificationToken']) {
        return $token['VerificationToken'];
      } else {
        return 'NULL';
      }      
    }

    static function changePassword(PDO $db, string $VerificationToken, string $Password) : void {
      
      $stmt = $db->prepare('UPDATE User Set Password = :Password, VerificationToken = :newVerificationToken where VerificationToken = :VerificationToken');
      $stmt->bindParam(':VerificationToken', $VerificationToken);
      $stmt->bindParam(':Password', $Password);
      $stmt->bindParam(':newVerificationToken', User::generateNewToken($db));

      $stmt->execute();  
    }

    static function confirmAccount(PDO $db, string $VerificationToken) : void {
      
      $stmt = $db->prepare('UPDATE User Set EmailVerified = true where VerificationToken = :VerificationToken');
      $stmt->bindParam(':VerificationToken', $VerificationToken);

      $stmt->execute();  
    }

    static function updateAccountToken(PDO $db, string $VerificationToken) : void {
      
      $stmt = $db->prepare('UPDATE User Set EmailVerified = true, VerificationToken = :newVerificationToken where VerificationToken = :VerificationToken');
      $stmt->bindParam(':VerificationToken', $VerificationToken);
      $stmt->bindParam(':newVerificationToken', User::generateNewToken($db));

      $stmt->execute();  
    }

    static function createUser(PDO $db, string $Username, string $Password, string $Email, string $Address, string $Phone_number, string $Birthdate) : void {
      $VerificationToken = User::generateNewToken($db);

      $stmt = $db->prepare('INSERT INTO User (Username, Password, Email, Address, Phone_number, Birthdate, EmailVerified, VerificationToken) values (:Username, :Password, :Email, :Address, :Phone_number, :Birthdate, false, :VerificationToken);');
      $stmt->bindParam(':Username', $Username);
      $stmt->bindParam(':Password', $Password);
      $stmt->bindParam(':Email', $Email);
      $stmt->bindParam(':Address', $Address);
      $stmt->bindParam(':Phone_number', $Phone_number);
      $stmt->bindParam(':Birthdate', $Birthdate);
      $stmt->bindParam(':VerificationToken', $VerificationToken);

      $stmt->execute();
    }

    static function updateUserInfo(PDO $db, string $User_id, string $Username, string $Email, string $Address, string $Phone_number, string $Birthdate, string $Password, string $Picture) : void {
      
      $sql = 'UPDATE User Set Username = :Username, Email = :Email, Address = :Address, Phone_number = :Phone_number, Birthdate = :Birthdate';
      
      if ($Password != '') {
        $sql =  $sql . ', Password = :Password';
      }
      if ($Picture != '') {
        $sql =  $sql . ', Picture = :Picture';
      }
      $sql =  $sql . ' Where User_id = :User_id;';

      
      $stmt = $db->prepare($sql);


      if ($Password != '') {
        $stmt->bindParam(':Password', $Password);
      }
      if ($Picture != '') {
        $stmt->bindParam(':Picture', $Picture);
      }

      $stmt->bindParam(':Username', $Username);
      $stmt->bindParam(':Email', $Email);
      $stmt->bindParam(':Address', $Address);
      $stmt->bindParam(':Phone_number', $Phone_number);
      $stmt->bindParam(':Birthdate', $Birthdate);
      $stmt->bindParam(':User_id', $User_id);

      $stmt->execute();
    }

  }
?>
<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>
<?php
//we'll put this at the top so both php block have access to it
if(isset($_GET["id"])){
	$id = $_GET["id"];
}
?>
<?php
//saving
if(isset($_POST["save"])){
	//TODO add proper validation/checks
	$account_number = $_POST["account_number"];
	$account_type = $_POST["account_type"];
	$opened_date = date('Y-m-d H:i:s');
	$last_updated = date('Y-m-d H:i:s');
	$balance = $_POST["balance"];
	$user_id = get_user_id();
	$db = getDB();
	if(isset($id)){
		$stmt = $db->prepare("UPDATE Accounts set account_number=:account_number, account_type=:account_type, balance=:balance where id=:id");
		$r = $stmt->execute([
		":account_number"=>$account_number,
		":account_type"=>$account_type,
		":balance"=>$balance,
		":id"=>$user_id
	 ]);
		if($r){
			flash("Updated successfully with id: " . $id);
		}
		else{
			$e = $stmt->errorInfo();
			flash("Error updating: " . var_export($e, true));
		}
	}
	else{
		flash("ID isn't set, we need an ID in order to update");
	}
}
?>
<?php
//fetching
$result = [];
if(isset($id)){
	$id = $_GET["id"];
	$db = getDB();
	$stmt = $db->prepare("SELECT * FROM Accounts where id = :id");
	$r = $stmt->execute([":id"=>$id]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<form method="POST">
	<label>Account Number</labe>
	<input name="account_number" placeholder="account number"/>
	<label>Account Type</label>
	<select name="account_type">
		<option value="0">Checking</option>
		<option value="1">Savings</option>
		<option value="2">Loan</option>
	</select>
	<label>Balance</label>
	<input type="number" min="1" name="balance"/>
	<input type="submit" name="save" value="Create"/>
</form>


<?php require(__DIR__ . "/partials/flash.php");

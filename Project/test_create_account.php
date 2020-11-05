<?php require_once(__DIR__ . "/partials/nav.php"); ?>

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

<?php
if(isset($_POST["save"])){
	//TODO add proper validation/checks
	$account_number = $_POST["account_number"];
	$account_type = $_POST["account_type"];
	$opened_date = date('Y-m-d H:i:s');
	$last_updated = date('Y-m-d H:i:s');
	$balance = $_POST["balance"];
	$user_id = get_user_id();
	$db = getDB();
	$stmt = $db->prepare("INSERT INTO Accounts (account_number, account_type, opened_date, last_updated, balance, user_id) VALUES(:account_num, :account_type, :opened, :updated,:balance,:user)");
	$r = $stmt->execute([
		":account_num"=>$account_number,
		":account_type"=>$account_type,
		":opened"=>$opened_date,
		":updated"=>$last_updated,
		":balance"=>$balance,
		":user"=>$user_id
	]);
	if($r){
		flash("Created successfully with id: " . $db->lastInsertId());
	}
	else{
		$e = $stmt->errorInfo();
		flash("Error creating: " . var_export($e, true));
	}
}
?>
<?php require(__DIR__ . "/partials/flash.php");

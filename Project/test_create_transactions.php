<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>
    <h3>Create Transaction</h3>
    <form method="POST">
        <label>Amount</label>
        <input name="amount" placeholder="Amount"/>
	<label>Action Type</label>
	<select name="action_type">
		<option value="0">Deposit</option>
		<option value="1">Withdrawal</option>
		<option value="2">Transfer</option>
	</select>
        <label>Memo</label>
        <input type="text" name="memo"/>
        <input type="submit" name="save" value="Create"/>
    </form>

<?php
if (isset($_POST["save"])) {
    //TODO add proper validation/checks
    $amount = $_POST["amount"];
    $action_type = $_POST["action_type"];
    $memo = $_POST["memo"];
    $expected_total = $_POST["expected_total"];
    $user_id = get_user_id();
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Transactions (amount, action_type, memo, expected_total, user_id) VALUES(:amount, :action_type, :memo,:expected_total,:user)");
    $r = $stmt->execute([
        ":amount" => $amount,
        ":action_type" => $action_type,
        ":memo" => $memo,
        ":expected_total" => $expected_total,
        ":user" => $user_id
    ]);
    if ($r) {
        flash("Created successfully with id: " . $db->lastInsertId());
    }
    else {
        $e = $stmt->errorInfo();
        flash("Error creating: " . var_export($e, true));
    }
}
?>
<?php require(__DIR__ . "/partials/flash.php");

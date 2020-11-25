
<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php require_once(__DIR__ . "/lib/helpers.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>

<?php
//we'll put this at the top so both php block have access to it
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
?>

    <h3>Create Transaction</h3>
    <form method="POST">
	<label>Amount</label>
        <input type="number" name="amount" min="0" placeholder="0.00"/>
        <label>Account Source</label>
        <select name="act_src_id">
            <?php foreach ($accounts as $account): ?>
                <option value="<?php safer_echo($account["id"]); ?>"
                ><?php safer_echo($account["account_number"]); ?></option>
            <?php endforeach;?>
        </select>
        <label>Account Destination</label>
        <select name="act_dest_id">
            <?php foreach ($accounts as $account): ?>
                <option value="<?php safer_echo($account["id"]); ?>"
                ><?php safer_echo($account["account_number"]); ?></option>
            <?php endforeach;?>
        </select>
        <label>Action Type</label>
        <select name="action_type">
            <option value="deposit">Deposit</option>
            <option value="withdraw">Withdraw</option>
            <option value="transfer">Transfer</option>
        </select>
        <label>Memo</label>
        <input type="text" name="memo"/>
        <input type="submit" name="save" value="Create"/>
    </form>

<?php
if (isset($_POST["save"])) {
    //TODO add proper validation/checks
    //$total=expected_total
    $amount = $_POST["amount"];
    $source = $_POST["act_src_id"];
    $dest = $_POST["act_dest_id"];
    $type = $_POST["action_type"];
    $memo = $_POST["memo"];
    $user_id = get_user_id();
    $db = getDB();
    if (isset($id)) {
        $stmt = $db->prepare("INSERT INTO Transactions (amount, act_src_id, act_dest_id, action_type, memo) VALUES(:amount, :source, :dest,:type, :memo)");
        $r = $stmt->execute([
	"amount" => $amount,
        ":act_src_id" => $source,
        ":act_dest_id" => $dest,
        ":action_type" => $type,
        ":memo" => $memo,
	":id" => $id
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



<?php
//fetching
$result = [];
if (isset($id)) {
    $id = $_GET["id"];
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM Transactions where id = :id");
    $r = $stmt->execute([":id" => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
$db = getDB();
$stmt = $db->prepare("SELECT id,name from Accounts LIMIT 10");
$r = $stmt->execute();
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<?php
    if (isset($_POST['action_type']) && isset($_POST['act_src_id']) && isset($_POST['act_dest_id']) && isset($_POST['amount'])) {
	$type = $_POST['action_type'];
	$amount = (int)$_POST['amount'];
        switch ($action_type) {
            case 'Deposit':
                doAction("000000000000", $act_dest_id, ($amount * -1), $action_type);
                break;
            case 'Withdraw':
                doAction($act_src_id, $"000000000000", ($amount * -1), $action_type);
                break;
            case 'Transfer':
                doAction($act_src_id, $act_dest_id, ($amount * -1), $action_type);
                break;
        }
    }

?>
<?php require(__DIR__ . "/partials/flash.php");

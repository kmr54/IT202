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
        <input type="action_type" min="1" name="action_type"/>
        <label>Memo</label>
        <input type="text" name="memo"/>
        <input type="submit" name="save" value="Create"/>
    </form>

<?php
if (isset($_POST["save"])) {
    //TODO add proper validation/checks
    $amount = $_POST["amount"];
    $type = $_POST["action_type"];
    $memo = $_POST["memo"];
    $total = $_POST["expected_total"];
    $user = get_user_id();
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Transactions (amount, action_type, memo, total, user_id) VALUES(:amount, :type, :memo,:total,:user)");
    $r = $stmt->execute([
        ":amount" => $amount,
        ":type" => $type,
        ":memo" => $memo,
        ":total" => $total,
        ":user" => $user
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

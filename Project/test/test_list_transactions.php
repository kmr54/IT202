<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>
<?php
$query = "";
$results = [];
if (isset($_POST["query"])) {
    $query = $_POST["query"];
}
if (isset($_POST["search"]) && !empty($query)) {
    $db = getDB();
<<<<<<< HEAD
    $stmt = $db->prepare("SELECT history.id, history.act_src_id, history.act_dest_id, history.amount, history.action_type, history.memo, Users.username 
from Transactions as history JOIN Users on history.user_id = Users.id LEFT JOIN Accounts as account on history.act_src_id = account.id WHERE history.amount like :q LIMIT 10");
    $r = $stmt->execute([":q" => $query]);
=======
    $stmt = $db->prepare("SELECT history.id,history.amount,account.amount as account, Users.username from Transactions as history JOIN Users on history.user_id = Users.id LEFT JOIN Accounts as account on history.act_src_id = account.id WHERE history.amount like :q LIMIT 10");
    $r = $stmt->execute([":q" => "%$query%"]);
>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
    if ($r) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else {
        flash("There was a problem fetching the results " . var_export($stmt->errorInfo(), true));
    }
}
?>
<h3>List Transactions</h3>
<form method="POST">
    <input name="query" placeholder="Search" value="<?php safer_echo($query); ?>"/>
    <input type="submit" value="Search" name="search"/>
</form>
<div class="results">
    <?php if (count($results) > 0): ?>
        <div class="list-group">
            <?php foreach ($results as $r): ?>
                <div class="list-group-item">
<<<<<<< HEAD
		    <div>
=======
                    <div>
>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
                        <div>Amount:</div>
                        <div><?php safer_echo($r["amount"]); ?></div>
                    </div>
                    <div>
<<<<<<< HEAD
                        <div>Account Source:</div>
                        <div><?php safer_echo($r["act_src_id"]); ?></div>
                    </div>
                    <div>
                        <div>Account Destination:</div>
                        <div><?php safer_echo($r["act_dest_id"]); ?></div>
                    </div>
                    <div>
                        <div>Action Type:</div>
                        <div><?php safer_echo($r["action_type"]); ?></div>
                    </div>
                    <div>
                        <div>Memo:</div>
                        <div><?php safer_echo($r["memo"]); ?></div>
=======
                        <div>Account:</div>
                        <div><?php safer_echo($r["account"]); ?></div>
>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
                    </div>
                    <div>
                        <div>Owner:</div>
                        <div><?php safer_echo($r["username"]); ?></div>
                    </div>
                    <div>
<<<<<<< HEAD
                        <a type="button" href="test_edit_transaction.php?id=<?php safer_echo($r['id']); ?>">Edit</a>
                        <a type="button" href="test_view_transaction.php?id=<?php safer_echo($r['id']); ?>">View</a>
=======
                        <a type="button" href="test_edit_transactions.php?id=<?php safer_echo($r['id']); ?>">Edit</a>
                        <a type="button" href="test_view_transactions.php?id=<?php safer_echo($r['id']); ?>">View</a>
>>>>>>> 0a84ff8a2e27299bdd2417269c8cc41b542fa315
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No results</p>
    <?php endif; ?>
</div>


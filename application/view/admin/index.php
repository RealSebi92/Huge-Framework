<div class="container">
    <h1>Admin/index</h1>

    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>

        <div>
            This controller/action/view shows a list of all users in the system. with the ability to soft delete a user
            or suspend a user.
        </div>
        <div>
            <table id="usersTable" class="overview-table">
                <thead>
                <tr>
                    <td>Id</td>
                    <td>Avatar</td>
                    <td>Username</td>
                    <td>User's email</td>
                    <td>Activated ?</td>
                    <td>Account Type</td> <!-- Added column for admin role managment-->
                    <td>Link to user's profile</td>
                    <td>suspension Time in days</td>
                    <td>Soft delete</td>
                    <td>Submit</td>
                </tr>
                </thead>
                <?php foreach ($this->users as $user) { ?>
                    <tr class="<?= ($user->user_active == 0 ? 'inactive' : 'active'); ?>">
                        <td><?= $user->user_id; ?></td>
                        <td class="avatar">
                            <?php if (isset($user->user_avatar_link)) { ?>
                                <img src="<?= $user->user_avatar_link; ?>"/>
                            <?php } ?>
                        </td>
                        <td><?= $user->user_name; ?></td>
                        <td><?= $user->user_email; ?></td>
                        <td><?= ($user->user_active == 0 ? 'No' : 'Yes'); ?></td>
                        
                        <td>
                            <form method="post" action="<?= Config::get('URL'); ?>profile/changeUserRole">
                                <input type="hidden" name="user_id" value="<?= $user->user_id; ?>">

                                <!-- Dropdown for role change-->
                                <select name="user_account_type" onchange="this.form.submit()">
                                    <!-- Creates one dropdown option for each account type from the database -->
                                    <?php foreach ($this->account_types as $account_type) { ?>
                                        <option value="<?= $account_type->type_id; ?>"
                                            <?php if ($user->user_account_type == $account_type->type_id) echo 'selected'; ?>>
                                            <?= $account_type->type_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="<?= Config::get('URL') . 'profile/showProfile/' . $user->user_id; ?>">Profile</a>
                        </td>
                        <form action="<?= config::get("URL"); ?>admin/actionAccountSettings" method="post">
                            <td><input type="number" name="suspension" /></td>
                            <td><input type="checkbox" name="softDelete" <?php if ($user->user_deleted) { ?> checked <?php } ?> /></td>
                            <td>
                                <input type="hidden" name="user_id" value="<?= $user->user_id; ?>" />
                                <input type="submit" />
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </table>
            <!-- Initialize DataTable-->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    new DataTable('#usersTable');
                });
            </script>
        </div>
    </div>
</div>

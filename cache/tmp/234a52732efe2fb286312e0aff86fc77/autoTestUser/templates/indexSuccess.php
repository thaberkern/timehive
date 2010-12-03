<h1>Users List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>First name</th>
      <th>Last name</th>
      <th>Email</th>
      <th>Account</th>
      <th>Username</th>
      <th>Password</th>
      <th>Administrator</th>
      <th>Locked</th>
      <th>Deleted at</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user): ?>
    <tr>
      <td><a href="<?php echo url_for('testUser/edit?id='.$user->getId()) ?>"><?php echo $user->getId() ?></a></td>
      <td><?php echo $user->getFirstName() ?></td>
      <td><?php echo $user->getLastName() ?></td>
      <td><?php echo $user->getEmail() ?></td>
      <td><?php echo $user->getAccountId() ?></td>
      <td><?php echo $user->getUsername() ?></td>
      <td><?php echo $user->getPassword() ?></td>
      <td><?php echo $user->getAdministrator() ?></td>
      <td><?php echo $user->getLocked() ?></td>
      <td><?php echo $user->getDeletedAt() ?></td>
      <td><?php echo $user->getCreatedAt() ?></td>
      <td><?php echo $user->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('testUser/new') ?>">New</a>

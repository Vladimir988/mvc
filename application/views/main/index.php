<div class="container" style="padding: 100px 0;">
  <div class="row">
    <div class="col-md-12">
      <a href="/user/add" class="btn btn-primary" style="margin-bottom: 20px;">Add New User</a>
      <table class="table" data-table="users">
        <thead>
          <tr>
            <th scope="col" class="id">ID</th>
            <th scope="col" class="name">Name</th>
            <th scope="col" class="email">Email</th>
            <th scope="col" class="country">Country</th>
            <th scope="col" class="actions">Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php
          foreach( $users as $user ) {
            echo sprintf(
              '<tr>
                <td class="user_id">%1$s</td>
                <td>%2$s</td>
                <td>%3$s</td>
                <td>%4$s</td>
                <td>%5$s</td>
              </tr>',

              $user['ID'],
              $user['name'],
              $user['email'],
              $user['country'],
              '<button class="btn btn-outline-primary user_action" data-action="edit_user"><i class="fa fa-pencil-square-o"></i></button> <button class="btn btn-outline-danger user_action" data-action="delete_user"><i class="fa fa-trash"></i></button>'
            );
          }
        ?>
        </tbody>
      </table>
      <a href="/user/add" class="btn btn-primary" style="margin-bottom: 20px;">Add New User</a>
      <?php
        $page = ( isset( $_GET['p'] ) ) ? $_GET['p'] : 1;
        echo get_pagination( $count_pages, $page );
      ?>
    </div>
  </div>
</div>
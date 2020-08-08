<?php
  if( ! isset( $user ) ) { header( 'Location: /' ); exit; }
?>
<div class="container" style="padding: 100px 0;">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <form action="/user/edit" method="POST" class="editUser">
        <div class="form-group">
          <input type="hidden" name="table" class="form-control" value="users">
          <input type="hidden" name="userid" class="form-control" value="<?=$user['ID']?>">
        </div>
        <div class="form-group">
          <label for="">Name</label>
          <input type="text" name="name" class="form-control" required value="<?=$user['name']?>">
        </div>
        <div class="form-group" style="position: relative;">
          <label for="">Email</label>
          <input type="email" name="email" class="form-control" required value="<?=$user['email']?>">
        </div>
        <div class="form-group">
          <label for="select-country">Country</label>
          <select name="country" class="form-control" id="select-country">
            <?php
              foreach( $countries as $country ) {
                $selected = ( $country['country_name'] == $user['country'] ) ? 'selected' : '';
                echo sprintf( '<option value="%1$s" %2$s>%1$s</option>', $country['country_name'], $selected );
              }
            ?>
          </select>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-success form-submit" value="Edit User">
        </div>
      </form>
    </div>
  </div>
</div>
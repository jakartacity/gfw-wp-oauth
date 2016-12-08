<?php
include_once "gfwoa-settings-screeen-controller.php";
?>
<form method="POST" action="<?php echo $menu_page_url;?>">
<h1>Global Fishing Watch OAuth Options</h1>
<div class="divtd">End Point</div>
<div class="divtd2"><input type=text name="gfw-endpoint" value="<?php echo $end_point;?>" disabled/></div><div class="breakline" />
<div class="divtd">Client ID</div>
<div class="divtd2"><input type=text name="gfw-client-id" value="<?php echo $client_id;?>" disabled /></div><div class="breakline" />
<div class="divtd">Redirect Page Title</div>
<div class="divtd2"><input type=text value="<?php echo $redirect_page_title;?>" disabled name="gfw-redirect_page" /></div><div class="breakline" />
<div class="divtd">Redirect URL</div>
<div class="divtd2"><input type=text name="gfw-redirect-url" disabled value="<?php echo $end_point_value;?>" /></div><div class="breakline" />
<div class="divtd"><input type="submit" value="Save Settings" class="button button-primary" name="submit"></input></div>
</form>
<?php
?>

<?php if (@$user_profile): ?>
<div class='fbpicture'><img src='http://graph.facebook.com/<?php echo $user_profile['id']?>/picture' /></div>
<div class='fbuser'>Welcome <?php echo $user_profile['name']?></div>
<div class='fbsignup'><a href='/cliq2/auth_other/fb_signin'>Signup</a></div>
<?php else: ?>
<div class='fbuser'><fb:login-button
registration-url="<?=$login_url?>" /></div>
<?php endif; ?>	
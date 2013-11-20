<div class='loginbutton'>
    <span>Login:</span>
    <?php if (@$user_profile): ?>
    <a href='/auth_other/fb_signin'><img src='/img/board/facebook.png' class='fblogin'/></a>
    <?php else: ?>
    <div class='fbuser'><fb:login-button
    registration-url="<?=$login_url?>" /></div>
    <?php endif; ?>	
    <a href='/cliqedit/auth/login'><img src='/cliqedit/img/board/cliqicon.png'/></a>
</div>
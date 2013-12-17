<div class='loginbutton'>
    <span>Login:</span>
    <?php if (@$user_profile): ?>
    <a href='/auth_other/fb_signin'><img src='/cliq/img/board/facebook.png' class='fblogin'/></a>
    <?php else: ?>
    <div class='fbuser'><fb:login-button
    registration-url="<?=$login_url?>" /></div>
    <?php endif; ?>	
    <div class='cliqlogin'><a href='auth/login'><img src='/cliq/img/board/cliqicon.png'/></a></div>
</div>
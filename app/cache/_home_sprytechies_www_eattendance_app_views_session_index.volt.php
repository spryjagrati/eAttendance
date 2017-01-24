
<div class="container">
<?php echo $this->assets->outputCss('headercss'); ?>

<div class="row">

    <div class="col-md-6">

    <?php echo $this->flash->output(); ?>
        <div class="page-header">
            <h2>Log In</h2>
        </div>
        <?php echo $this->tag->form(array('session/start', 'role' => 'form')); ?>
            <fieldset>
                <div class="form-group">
                    <label for="email">Username/Email</label>
                    <div class="controls">
                        <?php echo $this->tag->textField(array('email', 'class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="controls">
                        <?php echo $this->tag->passwordField(array('password', 'class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $this->tag->submitButton(array('Login', 'class' => 'btn btn-primary btn-large')); ?>
                </div>
            </fieldset>
        </form>
    </div>

    <div class="col-md-6">

        <div class="page-header">
            <h2>Don't have an account yet?</h2>
        </div>

        <p>Ask your admin to create an account for you:</p>
        <ul>
            <li>Create, track and export your invoices online</li>
            <li>Gain critical insights into how your business is doing</li>
            <li>Stay informed about promotions and special packages</li>
        </ul>
    </div>

</div>
</div>
<?php echo $this->assets->outputJs('footerjs'); ?>
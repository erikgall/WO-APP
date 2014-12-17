<div class="row">
	<div class="col-sm-6 col-md-4 col-md-offset-4" style="margin-top: 50px;">
	
    	<div class="panel panel-default">
		
			<div class="panel-heading">

				<strong> Sign in to continue</strong>

			</div>
			
            <div class="panel-body">
			
            	<?php echo form_open(); ?>
					
                    <fieldset>
					
                    	<div class="row">
						
                        	<div class="center-block text-center">
								
                                <?php 
									
									echo img(
										array(
											'src' => 'assets/img/no_profile.jpg', 
											'alt' => 'profile image',
											'style' => 'margin: 10px auto',
											'class' => 'img-circle img-responsive'
										)
									);		
								?>

							</div>

						</div>

						<div class="row">

							<div class="col-sm-12 col-md-10  col-md-offset-1 ">

								<div class="form-group">

									<div class="input-group">
									
                                    	<span class="input-group-addon">
										
                                        	<i class="glyphicon glyphicon-user"></i>
										
                                        </span> 
										
                                        <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
								
                                	</div>
								
                                </div>
							
                            	<div class="form-group">
								
                                	<div class="input-group">
									
                                    	<span class="input-group-addon">
										
                                        	<i class="glyphicon glyphicon-lock"></i>
											
                                   		</span>
									
                                    	<input class="form-control" placeholder="Password" name="password" type="password" value="">
									
                                    </div>
						
                        		</div>
							
                            	<div class="form-group">
								
                                	<input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign in">
								
                                </div>
							
                            </div>
					
                    	</div>
					
                    </fieldset>
				
                <?php echo form_close(); ?>
			
            </div>
		
        	<div class="panel-footer ">
			
            	Don't have an account! <a href="#" onClick=""> Sign Up Here </a>
			
            </div>
	
    	</div>
	
    </div>

</div>
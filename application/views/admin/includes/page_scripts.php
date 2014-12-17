<script type="text/javascript">

<?php 
	
	$no_delete = array('invoice', 'accounting');
	
	
	$four = $this->uri->segment(4);
	$five = $this->uri->segment(5);

	if ((!in_array($four, $no_delete)) AND $five != 'edit' OR $five == NULL):
		
	
?>

	$(document).ready(function() {

		$('body').on('click', 'a[data-confirm]', function(ev) {

			var href = $(this).attr('href');

				if (!$('#dataConfirmModal').length) {

					$('body').append('<!-- Modal --><div class="modal fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title" id="myModalLabel">Please Confirm</h4></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-danger" aria-hidden="true" data-dismiss="modal">Cancel</button><a class="btn btn-primary" id="dataConfirmOK">Delete</a></div></div></div></div>');

				} 

				$('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));

				$('#dataConfirmOK').attr('href', href);

				$('#dataConfirmModal').modal({show:true});
		
				var url = '<?php echo site_url(); ?>admin/dashboard/ajax_delete/' + $(this).attr('data-src') + '/' + $(this).attr('data-id');

				$('#dataConfirmOK').click(function(ev) {

				$('#page-wrapper').html('<?php echo img("assets/img/indicator.gif"); ?>');

				ev.preventDefault();
	
				$('#dataConfirmModal').modal('hide')

				$.ajax({

					url: url,
					type: 'POST',
		
				}).done(function(html) {

					$( "#page-wrapper" ).html(html);

			});

		});				
				return false;

			});

		});


	$('body').on('click', '#dataConfirmOK', function(e) {

		e.preventDefault();
		e.stopImmediatePropagation();
		
		var url = '<?php echo site_url(); ?>admin/dashboard/ajax_delete/' + $(this).attr('data-src') + '/' + $(this).attr('data-id');

		$('#dataConfirmOK').click(function(ev) {

			$('#page-wrapper').html('<?php echo img("assets/img/indicator.gif"); ?>');

			ev.preventDefault();
	
			$('#dataConfirmModal').modal('hide')

			$.ajax({

				url: url,
				type: 'GET',
		
			}).done(function(html) {
				
				$( "#page-wrapper" ).html(html);

			});

		});

	});
	<?php endif; ?>

	$('body').on('click', 'a[data-target="ajax_edit"]', function(e) {
		e.stopImmediatePropagation();
		$('#page-wrapper').addClass('animated').addClass('slideOutRight');
		
		e.preventDefault();	
		$.ajax({
			url: '<?php echo site_url(); ?>admin/dashboard/ajax_edit/' + $(this).attr('data-src') + '/' + $(this).attr('data-id'),
			type: 'GET',

		}).done(function(html) {
			$("#page-wrapper").removeClass('slideOutRight').addClass('slideInRight');
			$( "#page-wrapper" ).html(html);
			window.localStorage.clear();

		});

	});
	
</script>
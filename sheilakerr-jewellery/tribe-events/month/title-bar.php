<?php
/**
 * List View Title Template
 * The title template for the list view of events.
 * @package TribeEventsCalendar
 * @version 4.6.19
 * @since   4.6.19
 *
 */
?>

<div class="tribe-events-title-bar">
	<!-- List Title -->
	<?php do_action( 'tribe_events_before_the_title' ); ?>
	<h2 class="tribe-events-page-title"><?php echo tribe_get_events_title() ?></h2>
	<?php do_action( 'tribe_events_after_the_title' ); ?>

</div>

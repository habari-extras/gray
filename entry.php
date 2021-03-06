<div id="post-<?php echo $content->id; ?>" class="entry <?php echo $content->statusname; ?>">
	<div class="entry-head">
		<h2 class="entry-title"><a href="<?php echo $content->permalink; ?>" title="<?php echo $content->title; ?>"><?php echo $content->title_out; ?></a></h2>

		<div class="entry-meta">
			<span class="chronodata published"><?php echo $content->pubdate_ago; ?></span> &middot; 
			<span class="commentslink"><a href="<?php echo $content->permalink; ?>#comments" title="<?php _e('Comments on this post', 'resurrection'); ?>"><?php printf(_n( '%d Comment', '%d Comments', $content->comments->approved->count, 'resurrection' ), $content->comments->approved->count); ?></a></span>
			<?php if ( is_object($user) && $user->can('edit_post') ) : ?>
			 &middot; 	<span class="entry-edit"><a href="<?php echo $content->editlink; ?>" title="<?php _e('Edit post', 'resurrection'); ?>"><?php _e('Edit', 'resurrection'); ?></a></span>
			<?php endif; ?>
			<?php if ( is_array( $content->tags ) ) : ?>
			 &middot; 	<span class="entry-tags"><?php echo $content->tags_out; ?></span>
			<?php endif; ?>
		</div>
	</div>
	<div class="entry-content">
		<?php echo $content->content_out; ?>
	</div>
	<?php if($request->display_entry): ?>
	<h3 id="others">Other Posts</h3>
	<?php
		$others = array();
		$others['Older'] = $post->descend();
		$others['Newer'] = $post->ascend();
		foreach($post->tags as $tag) {
			//$other = Post::get('limit=1&vocabulary[tags:all:term]=habari');
			//$other = Post::get('limit=1&vocabulary=tags:all:term_display=habari');
			$other = Post::get(array('vocabulary' => 'tags[any:term][]=habari&tags[any:term][]=foo'));
			//$other = Post::get(array('limit'=> 1, 'before' => $post->pubdate->format('Y-m-d'), 'vocabulary'=> 'tags[all:term]=' . $tag->term));
			//$other = Post::get('limit=1&before=' . $post->pubdate->format('Y-m-d') . '&vocabulary[tags][all:term]=' . $tag->term);
			/*
			$other = Post::get(
				array(
					'limit' => 1,
					'vocabulary' => array('all'=>array($tag)),
					'before' => $post->pubdate,
				)
			);
			//*/
			$others['On ' . $tag] = $other;
		}
		$others = array_filter($others);
	?>
	<ul class="other_posts">
	<?php foreach($others as $othername => $other): ?>
	<li><b><?php echo $othername; ?>:</b> <a href="<?php echo $other->permalink; ?>"><?php echo htmlspecialchars($other->title); ?></a></li>
	<?php endforeach; ?>
	</ul>
	<?php if(!$post->info->comments_disabled || $content->comments->moderated->comments->count > 0): ?>
	<h3 id="comments">Comments</h3>
	<ol class="entry-comments">
	<?php foreach($content->comments->moderated->comments as $comment): ?>
		<li>
			<?php $theme->content($comment); ?>
		</li>
	<?php endforeach; ?>
	</ol>
	<?php endif; ?>
	<?php if(!$post->info->comments_disabled): ?>
	<?php $post->comment_form()->out();	?>
	<?php endif; ?>
	<?php endif; ?>

</div>
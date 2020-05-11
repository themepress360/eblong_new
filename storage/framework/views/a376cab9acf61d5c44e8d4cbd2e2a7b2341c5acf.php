<div class="wt-tabscontenttitle">
    <h2><?php echo e(trans('lang.videos')); ?></h2>
</div>
<div class="wt-skillsform">
    <fieldset class="social-icons-content">
        <?php if(!empty($videos)): ?>
            <?php $counter = 0 ?>
            <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video_key => $mem_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="wrap-social-icons wt-haslayout">
                    <div class="form-group">
                        <div class="form-group-holder">
                            <?php echo Form::text('video['.$counter.'][url]', e($mem_value['url']),
                            ['class' => 'form-control']); ?>

                        </div>
                        <div class="form-group wt-rightarea">
                            <?php if($video_key == 0 ): ?>
                                <span class="wt-addinfobtn" @click="addVideo"><i class="fa fa-plus"></i></span> 
                            <?php else: ?>
                                <span class="wt-addinfobtn wt-deleteinfo delete-social" data-check="<?php echo e($counter); ?>">
                                    <i class="fa fa-trash"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php $counter++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="wrap-social-icons wt-haslayout">
                <div class="form-group">
                    <div class="form-group-holder">
                        <?php echo Form::text('video[0][url]', null, ['class' => 'form-control',
                            'placeholder' => trans('lang.video_url')]); ?>

                    </div>
                    <div class="form-group wt-rightarea">
                        <span class="wt-addinfobtn" @click="addVideo"><i class="fa fa-plus"></i></span>
                    </div>
                </div>
                
            </div>
        <?php endif; ?>
            <div v-for="(video, index) in videos" v-cloak>
                <div class="wrap-social-icons wt-haslayout">
                    <div class="form-group">
                        <div class="form-group-holder">
                            <input v-bind:name="'video['+[video.count]+'][url]'" type="text" class="form-control"
                            v-model="video.url" placeholder="<?php echo e(trans('lang.video_url')); ?>">
                        </div>
                        <div class="form-group wt-rightarea">
                            <span class="wt-addinfobtn wt-deleteinfo" @click="removeVideo(index)"><i class="fa fa-trash"></i></span>
                        </div>
                    </div>
                </div>
            </div>
    </fieldset>
</div>

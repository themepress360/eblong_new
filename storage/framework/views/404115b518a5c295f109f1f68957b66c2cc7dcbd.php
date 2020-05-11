
<?php $__env->startSection('content'); ?>
    <?php
        $verified_user = \App\User::select('user_verified')
        ->where('id', $job->employer->id)->pluck('user_verified')->first();
    ?>
    <section class="wt-haslayout wt-dbsectionspace la-dbproposal" id="jobs">
        <?php if(Session::has('error')): ?>
            <div class="flash_msg">
                <flash_messages :message_class="'danger'" :time='5' :message="'<?php echo e(Session::get('error')); ?>'" v-cloak></flash_messages>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <?php if($proposal->status == "cancelled" && !empty($cancel_reason)): ?>
                    <div class="wt-jobalertsholder">
                        <ul class="wt-jobalerts">
                            <li class="alert alert-danger alert-dismissible fade show">
                                <span><em><?php echo e(trans('lang.sorry')); ?></em> <?php echo e(trans('lang.job_cancelled')); ?></span>
                                <a href="javascript:void(0)" class="wt-alertbtn danger" v-on:click.prevent="viewReason('<?php echo e($cancel_reason->description); ?>')" ><?php echo e(trans('lang.reason')); ?></a>
                                <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle">
                        <h2><?php echo e(trans('lang.job_dtl')); ?></h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-jobdetailsholder">
                        <div class="wt-freelancerholder wt-tabsinfo">
                            <div class="wt-jobdetailscontent">
                                <div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
                                    <?php if(!empty($job->is_featured) && $job->is_featured === 'true'): ?>
                                        <span class="wt-featuredtag">
                                            <img src="<?php echo e(asset('images/featured.png')); ?>" alt="<?php echo e(trans('lang.is_featured')); ?>"
                                                data-tipso="Plus Member" class="template-content tipso_style">
                                        </span>
                                    <?php endif; ?>
                                    <div class="wt-userlistingcontent">
                                        <div class="wt-contenthead">
                                            <?php if(!empty($employer_name) || !empty($job->title) ): ?>
                                                <div class="wt-title">
                                                    <?php if(!empty($employer_name)): ?>
                                                        <a href="<?php echo e(url('profile/'.$job->employer->slug)); ?>">
                                                            <?php if($verified_user === 1): ?>
                                                                <i class="fa fa-check-circle"></i>&nbsp;
                                                            <?php endif; ?>
                                                            <?php echo e($employer_name); ?>

                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if(!empty($job->title)): ?>
                                                        <h2><?php echo e($job->title); ?></h2>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <ul class="wt-userlisting-breadcrumb">
                                                <?php if(!empty($job->price)): ?>
                                                    <li><span><i class="far fa-money-bill-alt"></i> <?php echo e(!empty($symbol) ? $symbol['symbol'] : '$'); ?><?php echo e($job->price); ?></span></li>
                                                <?php endif; ?>
                                                <?php if(!empty($job->location->title)): ?>
                                                    <li>
                                                        <span>
                                                            <img src="<?php echo e(asset(Helper::getLocationFlag($job->location->flag))); ?>"
                                                            alt="<?php echo e(trans('lang.img')); ?>"> <?php echo e($job->location->title); ?>

                                                        </span>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                        <div class="wt-rightarea">
                                            <div class="wt-hireduserstatus">
                                                <figure><img src="<?php echo e(asset($employer_image)); ?>" alt="<?php echo e(trans('lang.profie_img')); ?>"></figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wt-projecthistory">
                            <div class="wt-tabscontenttitle">
                                <h2><?php echo e(trans('lang.project_history')); ?></h2>
                            </div>
                            <div class="wt-historycontent">
                                <private-message :ph_job_dtl="'<?php echo e(trans('lang.ph_job_dtl')); ?>'" :upload_tmp_url="'<?php echo e(url('proposal/upload-temp-image')); ?>'" :id="'<?php echo e($proposal->id); ?>'" :recipent_id="'<?php echo e($job->user_id); ?>'"></private-message>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
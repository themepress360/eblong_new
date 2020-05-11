
<?php $__env->startSection('content'); ?>
    <?php
        $count = 0;
        $reviews = \App\Review::where('receiver_id', $accepted_proposal->freelancer_id)->count();
        $verified_user = \App\User::select('user_verified')->where('id', $job->employer->id)->pluck('user_verified')->first();
        $project_type  = Helper::getProjectTypeList($job->project_type);
    ?>
    <section class="wt-haslayout wt-dbsectionspace" id="jobs">
        <div class="preloader-section" v-if="loading" v-cloak>
            <div class="preloader-holder">
                <div class="loader"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <?php if(Session::has('success')): ?>
                    <div class="flash_msg">
                        <flash_messages :message_class="'success'" :time ='5' :message="'<?php echo e(Session::get('success')); ?>'" v-cloak></flash_messages>
                    </div>
                    <?php session()->forget('success'); ?>
                <?php elseif(Session::has('error')): ?>
                    <div class="flash_msg">
                        <flash_messages :message_class="'danger'" :time='5' :message="'<?php echo e(Session::get('error')); ?>'" v-cloak></flash_messages>
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
                                        <span class="wt-featuredtag"><img src="<?php echo e(asset('images/featured.png')); ?>" alt="<?php echo e(trans('lang.is_featured')); ?>" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                    <?php endif; ?>
                                    <div class="wt-userlistingcontent">
                                        <div class="wt-contenthead">
                                            <?php if(!empty($employer_name) || !empty($job->title) ): ?>
                                                <div class="wt-title">
                                                    <?php if(!empty($employer_name)): ?>
                                                        <a href="<?php echo e(url('profile/'.$job->employer->slug)); ?>"><?php if($verified_user === 1): ?><i class="fa fa-check-circle"></i><?php endif; ?>&nbsp;<?php echo e($employer_name); ?></a>
                                                    <?php endif; ?>
                                                    <?php if(!empty($job->title)): ?>
                                                        <h2><?php echo e($job->title); ?></h2>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if(!empty($job->price) ||
                                                !empty($job->location->title)): ?>
                                                <ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
                                                    <?php if(!empty($job->price)): ?>
                                                        <li><span class="wt-dashboraddoller"><i><?php echo e(!empty($symbol) ? $symbol['symbol'] : '$'); ?></i> <?php echo e($job->price); ?></span></li>
                                                    <?php endif; ?>
                                                    <?php if(!empty($job->location->title)): ?>
                                                        <li><span><img src="<?php echo e(asset(App\Helper::getLocationFlag($job->location->flag))); ?>" alt="<?php echo e(trans('lang.img')); ?>"> <?php echo e($job->location->title); ?></span></li>
                                                    <?php endif; ?>
                                                    <?php if(!empty($job->project_type)): ?>
                                                        <li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> <?php echo e(trans('lang.type')); ?> <?php echo e($project_type); ?></a></li>
                                                    <?php endif; ?>
                                                    <?php if(!empty($job->duration)): ?>
                                                        <li><span class="wt-dashboradclock"><i class="far fa-clock"></i> <?php echo e(trans('lang.duration')); ?> <?php echo e($duration); ?></span></li>
                                                    <?php endif; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                        <div class="wt-rightarea">
                                            <?php if($job->status === 'hired'): ?>
                                                <div class="wt-hireduserstatus">
                                                    <h4><?php echo e(trans('lang.hired')); ?></h4>
                                                    <span><?php echo e($freelancer_name); ?></span>
                                                    <ul class="wt-hireduserimgs">
                                                        <li><figure><img src="<?php echo e(asset($profile_image)); ?>" alt="<?php echo e(trans('lang.profile_img')); ?>" class="mCS_img_loaded"></figure></li>
                                                    </ul>
                                                </div>
                                            <?php elseif($job->status === 'completed'): ?>
                                                <div class="wt-hireduserstatus">
                                                    <h4><?php echo e(trans('lang.completed')); ?></h4>
                                                    <span><?php echo e($freelancer_name); ?></span>
                                                    <ul class="wt-hireduserimgs">
                                                        <li><figure><img src="<?php echo e(asset($profile_image)); ?>" alt="<?php echo e(trans('lang.profile_img')); ?>" class="mCS_img_loaded"></figure></li>
                                                    </ul>
                                                </div>
                                            <?php else: ?>
                                                <div class="wt-hireduserstatus">
                                                    <?php if(Auth::user()->getRoleNames()[0] == "admin"): ?>
                                                        <h4><?php echo e(trans('lang.job_cancelled')); ?></h4>
                                                    <?php else: ?>
                                                        <h5><?php echo e(trans('lang.no_freelancers')); ?></h5>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wt-rcvproposalholder wt-hiredfreelancer wt-tabsinfo">
                            <div class="wt-tabscontenttitle">
                                <h2><?php echo e(trans('lang.hired_freelancers')); ?></h2>
                            </div>
                            <div class="wt-jobdetailscontent">
                                <?php if(!empty($accepted_proposal)): ?>
                                    <div class="wt-userlistinghold wt-featured wt-proposalitem">
                                        <figure class="wt-userlistingimg">
                                            <img src="<?php echo e(asset($profile_image)); ?>" alt="<?php echo e(trans('lang.is_featured')); ?>" class="mCS_img_loaded">
                                        </figure>
                                        <div class="wt-proposaldetails">
                                            <?php if(!empty($freelancer_name)): ?>
                                                <div class="wt-contenthead">
                                                    <div class="wt-title">
                                                        <a href="<?php echo e(url('profile/'.$user_slug)); ?>"><?php echo e($freelancer_name); ?></a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="wt-proposalfeedback">
                                                <span class="wt-stars"><span style="width: <?php echo e($stars); ?>%;"></span></span>
                                                <span class="wt-starcontent"><?php echo e(round($average_rating_count)); ?><sub><?php echo e(trans('lang.5')); ?></sub> <em>(<?php echo e($feedbacks); ?> <?php echo e(trans('lang.feedbacks')); ?>)</em></span>
                                            </div>
                                        </div>
                                        <div class="wt-rightarea wt-titlewithsearch">
                                            <?php if($job->status === 'hired' && Auth::user()->getRoleNames()->first() == 'employer'): ?>
                                                <form class="wt-formtheme wt-formsearch" id="change_job_status">
                                                    <fieldset>
                                                        <div class="form-group">
                                                            <span class="wt-select">
                                                                <?php echo Form::select('status', $project_status, $job->status, array('id' =>'job_status', 'data-placeholder' => trans('lang.select_status'), '@change' => 'jobStatus('.$job->id.', '.$accepted_proposal->id.', "'.$cancel_proposal_text.'", "'.$cancel_proposal_button.'", "'.$validation_error_text.'", "'.$cancel_popup_title.'")')); ?>

                                                            </span>
                                                            <a href="javascrip:void(0);" class="wt-searchgbtn job_status_popup" @click.prevent='jobStatus(<?php echo e($job->id); ?>, <?php echo e($accepted_proposal->id); ?>, "<?php echo e($cancel_proposal_text); ?>", "<?php echo e($cancel_proposal_button); ?>", "<?php echo e($validation_error_text); ?>", "<?php echo e($cancel_popup_title); ?>")'><i class="fa fa-check"></i></a>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            <?php endif; ?>
                                            <div class="wt-hireduserstatus">
                                                <h5><?php echo e(!empty($symbol) ? $symbol['symbol'] : '$'); ?><?php echo e($accepted_proposal->amount); ?></h5>
                                                <?php if(!empty($completion_time)): ?>
                                                    <span><?php echo e($completion_time); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="wt-hireduserstatus">
                                                <i class="far fa-envelope"></i>
                                                <a href="javascript:void(0);"  v-on:click.prevent="showCoverLetter('<?php echo e($accepted_proposal->id); ?>')"  ><span><?php echo e(trans('lang.cover_letter')); ?></span></a>
                                            </div>
                                            <?php if(!empty($attachments)): ?>
                                            <div class="wt-hireduserstatus">
                                                <i class="fa fa-paperclip"></i>
                                                <?php echo Form::open(['url' => url('proposal/download-attachments'), 'class' =>'post-job-form wt-haslayout', 'id' => 'download-attachments-form-'.$accepted_proposal->freelancer_id]); ?>

                                                    <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(Storage::disk('local')->exists('uploads/proposals/'.$accepted_proposal->freelancer_id.'/'.$attachment)): ?>
                                                            <?php echo Form::hidden('attachments['.$count.']', $attachment, []); ?>

                                                            <?php $count++; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo Form::hidden('freelancer_id', $accepted_proposal->freelancer_id, []); ?>

                                                <?php echo form::close();; ?>

                                                <a href="javascript:void(0);" v-on:click.prevent="downloadAttachments('<?php echo e('download-attachments-form-'.$accepted_proposal->freelancer_id); ?>')" ><span><?php echo e($count); ?> <?php echo e(trans('lang.file_attached')); ?></span></a>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="wt-projecthistory">
                            <div class="wt-tabscontenttitle">
                                <h2><?php echo e(trans('lang.project_history')); ?></h2>
                            </div>
                            <div class="wt-historycontent la-jobdetails-holder">
                                <private-message :placeholder="'<?php echo e(trans('lang.ph_job_dtl')); ?>'" :upload_tmp_url="'<?php echo e(url('proposal/upload-temp-image')); ?>'" :id="'<?php echo e($accepted_proposal->id); ?>'" :recipent_id="'<?php echo e($accepted_proposal->freelancer_id); ?>'"></private-message>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
            </div>
        </div>
        <b-modal ref="myModalRef-<?php echo e($accepted_proposal->id); ?>" hide-footer title="Cover Letter" v-cloak>
            <div class="d-block text-center">
                <?php echo e($accepted_proposal->content); ?>

            </div>
        </b-modal>
        <b-modal ref="myModalRef" hide-footer title="Project Status">
            <div class="d-block text-center">
                <form class="wt-formtheme wt-formfeedback" id="submit-review-form">
                    <fieldset>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="<?php echo e(trans('lang.add_your_feedback')); ?>" name="feedback"></textarea>
                        </div>
                        <?php if(!empty($review_options)): ?>
                            <?php $__currentLoopData = $review_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-group wt-ratingholder">
                                    <div class="wt-ratepoints">
                                        <vue-stars
                                            :name="'rating[<?php echo e($key); ?>][rate]'"
                                            :active-color="'#fecb02'"
                                            :inactive-color="'#999999'"
                                            :shadow-color="'#ffff00'"
                                            :hover-color="'#dddd00'"
                                            :max="5"
                                            :value="0"
                                            :readonly="false"
                                            :char="'★'"
                                            id="rating-<?php echo e($key); ?>"
                                        />
                                        <div class="counter wt-pointscounter"></div>
                                    </div>
                                    <input type="hidden" name="rating[<?php echo e($key); ?>][reason]" value="<?php echo e($option->id); ?>">
                                    <span class="wt-ratingdescription"><?php echo e($option->title); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <input type="hidden" name="receiver_id" value="<?php echo e($accepted_proposal->freelancer_id); ?>">
                        <input type="hidden" name="proposal_id" value="<?php echo e($accepted_proposal->id); ?>">
                        <div class="form-group wt-btnarea">
                            <a class="wt-btn" href="javascript:void(0);" v-on:click='submitFeedback(<?php echo e($accepted_proposal->freelancer_id); ?>, <?php echo e($job->id); ?>)'><?php echo e(trans('lang.btn_send_feedback')); ?></a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </b-modal>
    </section>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('content'); ?>
    <div class="cats-listing wt-addarticles-wrap" id="articles">
        <?php if(Session::has('message')): ?>
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
            </div>
        <?php elseif(Session::has('error')): ?>
            <div class="flash_msg">
                <flash_messages :message_class="'danger'" :time ='5' :message="'<?php echo e(Session::get('error')); ?>'" v-cloak></flash_messages>
            </div>
        <?php endif; ?>
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 float-left">
                    <div class="wt-dashboardbox la-article-box">
                        <div class="wt-dashboardboxtitle">
                            <h2><?php echo e(trans('lang.add_article')); ?></h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            <?php echo Form::open([
                                'url' => url('admin/articles/store-article'),
                                'class' =>'wt-formtheme la-articlebox-form', 'id'=> 'categories'
                                ]); ?>

                                <fieldset>
                                    <div class="form-group">
                                        <?php echo Form::text( 'title', null, ['class' =>'form-control'.($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => trans('lang.ph_title')] ); ?>

                                        <span class="form-group-description"><?php echo e(trans('lang.desc')); ?></span>
                                        <?php if($errors->has('title')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('title')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::textarea('description', null, ['class' => 'wt-tinymceeditor', 'id' => 'wt-tinymceeditor', 'placeholder' => trans('lang.ph_desc')]); ?>

                                        
                                        <span class="form-group-description"><?php echo e(trans('lang.article_desc')); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <span class="wt-select">
                                            <select name="cats[]" class="chosen-select" multiple data-placeholder = "<?php echo e(trans('lang.select_cats')); ?>">
                                                <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    
                                                    <option value="<?php echo e($key); ?>"><?php echo e($cat); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <upload-image
                                            :id="'article_image'"
                                            :img_ref="'article_ref'"
                                            :url="'<?php echo e(url('admin/articles/upload-temp-image')); ?>'"
                                            :name="'uploaded_image'"
                                            >
                                        </upload-image>
                                        <?php echo Form::hidden( 'uploaded_image', '', ['id'=>'hidden_img'] ); ?>

                                    </div>
                                    <div class="form-group wt-btnarea">
                                        <?php echo Form::submit(trans('lang.add_article'), ['class' => 'wt-btn']); ?>

                                    </div>
                                </fieldset>
                            <?php echo Form::close();; ?>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-8 float-right">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle wt-titlewithsearch">
                            <h2><?php echo e(trans('lang.articles')); ?></h2>
                            <?php echo Form::open(['url' => url('admin/articles/search'),
                                'method' => 'get', 'class' => 'wt-formtheme wt-formsearch']); ?>

                            <fieldset>
                                <div class="form-group">
                                    <input type="text" name="keyword" value="<?php echo e(!empty($_GET['keyword']) ? $_GET['keyword'] : ''); ?>"
                                        class="form-control" placeholder="<?php echo e(trans('lang.ph_search_articles')); ?>">
                                    <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                </div>
                            </fieldset>
                            <?php echo Form::close(); ?>

                            <a href="javascript:void(0);" v-if="this.is_show" @click="deleteChecked('<?php echo e(trans('lang.ph_delete_confirm_title')); ?>', '<?php echo e(trans('lang.ph_article_delete_message')); ?>')" class="wt-skilldel">
                                <i class="lnr lnr-trash"></i>
                                <span><?php echo e(trans('lang.del_select_rec')); ?></span>
                            </a>
                        </div>
                        <?php if($articles->count() > 0): ?>
                            <div class="wt-dashboardboxcontent wt-categoriescontentholder">
                                <table class="wt-tablecategories" id="checked-val">
                                    <thead>
                                        <tr>
                                            <th>
                                                <span class="wt-checkbox">
                                                    <input name="cats[]" id="wt-cats" @click="selectAll" type="checkbox" name="head">
                                                    <label for="wt-cats"></label>
                                                </span>
                                            </th>
                                            <th><?php echo e(trans('lang.cat_icon')); ?></th>
                                            <th><?php echo e(trans('lang.name')); ?></th>
                                            <th><?php echo e(trans('lang.slug')); ?></th>
                                            <th><?php echo e(trans('lang.action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter = 0; ?>
                                        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="del-<?php echo e($article->id); ?>">
                                                <td>
                                                    <span class="wt-checkbox">
                                                        <input name="cats[]" @click="selectRecord" value="<?php echo e($article->id); ?>" id="wt-check-<?php echo e($counter); ?>" type="checkbox" name="head">
                                                        <label for="wt-check-<?php echo e($counter); ?>"></label>
                                                    </span>
                                                </td>
                                                <td data-th="Icon"><span class="bt-content"><figure><img src="<?php echo e(asset(Helper::getImage('uploads/articles', $article->banner, '', 'small-default-article.png'))); ?>" alt="<?php echo e($article->title); ?>"></figure></span></td>
                                                <td><?php echo e($article->title); ?></td>
                                                <td><?php echo e($article->slug); ?></td>
                                                <td>
                                                    <div class="wt-actionbtn">
                                                        <a href="<?php echo e(url('admin/articles/edit-article')); ?>/<?php echo e($article->id); ?>" class="wt-addinfo wt-skillsaddinfo">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                        <delete :title="'<?php echo e(trans("lang.ph_delete_confirm_title")); ?>'" :id="'<?php echo e($article->id); ?>'" :message="'<?php echo e(trans("lang.ph_article_delete_message")); ?>'" :url="'<?php echo e(url('admin/articles/delete-article')); ?>'"></delete>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $counter++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <?php if( method_exists($articles,'links') ): ?>
                                    <?php echo e($articles->links('pagination.custom')); ?>

                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <?php if(file_exists(resource_path('views/extend/errors/no-record.blade.php'))): ?> 
                                <?php echo $__env->make('extend.errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php else: ?> 
                                <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
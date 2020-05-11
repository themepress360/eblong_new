<div class="wt-location wt-tabsinfo">
    <div class="wt-settingscontent">
        <?php if(!empty($reg_form_banner)): ?>
            <?php
                $image = '/uploads/settings/home/'.$reg_form_banner;
                $file_name = Helper::formateFileName($reg_form_banner);
            ?>
            <div class="wt-formtheme wt-userform">
                <div v-if="this.reg_form_banner">
                    <upload-image
                        :id="'reg_form_banner'"
                        :img_ref="'reg_form_ref'"
                        :url="'<?php echo e(url('admin/upload-temp-image/reg_form_banner')); ?>'"
                        :name="'reg_form_banner'">
                    </upload-image>
                </div>
                <div class="wt-uploadingbox" v-else>
                    <figure><img src="<?php echo e(asset($image)); ?>" alt="<?php echo e(trans('lang.banner_photo')); ?>"></figure>
                    <div class="wt-uploadingbar">
                        <div class="dz-filename"><?php echo e($file_name); ?></div>
                        <em><?php echo e(trans('lang.file_size')); ?><a href="javascript:void(0);" class="lnr lnr-cross" v-on:click.prevent="removeImage('hidden_reg_form_banner')"></a></em>
                    </div>
                </div>
                <input type="hidden" name="registration[0][reg_form_banner]" id="hidden_reg_form_banner" value="<?php echo e($reg_form_banner); ?>">
            </div>
        <?php else: ?>
            <div class="wt-formtheme wt-userform">
                <upload-image
                    :id="'reg_form_banner'"
                    :img_ref="'reg_form_ref'"
                    :url="'<?php echo e(url('admin/upload-temp-image/reg_form_banner')); ?>'"
                    :name="'reg_form_banner'">
                </upload-image>
                <input type="hidden" name="registration[0][reg_form_banner]" id="hidden_reg_form_banner">
            </div>
        <?php endif; ?>
    </div>
</div>

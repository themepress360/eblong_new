<nav id="wt-nav" class="wt-nav navbar-expand-lg">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="lnr lnr-menu"></i>
    </button>
    <div class="collapse navbar-collapse wt-navigation" id="navbarNav">
        <ul class="navbar-nav">
          		
            <li>
                <a href="<?php echo e(url('search-results?type=freelancer')); ?>">
                    <?php echo e(trans('lang.view_freelancers')); ?>

                </a>
            </li>
            
            <?php if($type =='jobs' || $type == 'both'): ?>
                <li>
                    <a href="<?php echo e(url('search-results?type=job')); ?>">
                        <?php echo e(trans('lang.browse_jobs')); ?>

                    </a>
                </li>
            <?php endif; ?>
            <?php if($type =='services' || $type == 'both'): ?>
                <li>
                    <a href="<?php echo e(url('search-results?type=service')); ?>">
                        <?php echo e(trans('lang.browse_services')); ?>

                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
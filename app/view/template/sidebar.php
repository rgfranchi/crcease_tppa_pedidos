<?php 
namespace TPPA\APP\view\template;

use TPPA\CORE\BasicFunctions;

use function TPPA\CORE\basic\pr;

// $basicFunctions = new BasicFunctions();
    // function navbarActive($active = false) {
    //     $basicFunctions = new BasicFunctions(); 
    //     var_dump($basicFunctions);
    //     return $basicFunctions->navbarActive($active);
    // }
?>
     
     <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion <?= @$_SESSION['menu']['toggled'] == 1 ? "toggled" : ""; ?>" id="accordionSidebar">
         <?php foreach ($navbar as $key_nav => $value_nav) : ?>
            <?php if (empty($value_nav)) {continue;} ?>
             <?php if ($value_nav['type'] === 'brand') : ?>
                 <!-- Sidebar - Brand -->
                 <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $value_nav['href']; ?>">
                     <?= isset($value_nav['icon']) ? sprintf('<div class="sidebar-brand-icon rotate-n-15"><i class="%s"></i></div>', $value_nav['icon']) : ""; ?>
                     <div class="sidebar-brand-text mx-3"><?= $value_nav['text']; ?></div>
                 </a>
                 <!-- Divider -->
                 <hr class="sidebar-divider my-0">
             <?php endif ?>
             <?php htmlLinks($value_nav, $key_nav); ?>
             <?php if ($value_nav['type'] === 'heading') : ?>
                <?php if (isset($value_nav['itens']) && !empty($value_nav['itens'])) : ?>
                    <!-- Divider -->
                    <hr class="sidebar-divider">
                    <!-- Heading -->
                    <div class="sidebar-heading">
                        <?= $value_nav['text'] ?>
                    </div>
                    <?php foreach($value_nav['itens'] as $key_itens => $value_itens ) : ?>
                        <?php htmlLinks($value_itens); ?>
                    <?php endforeach ?>    
                <?php endif ?>       
             <?php endif ?>

         <?php endforeach; ?>
         <!-- foreach $navbar;  -->

         <!-- Divider -->
         <hr class="sidebar-divider d-none d-md-block">

         <!-- Sidebar Toggler (Sidebar) -->
         <div class="text-center d-none d-md-inline">
             <button class="rounded-circle border-0" id="sidebarToggle"></button>
         </div>

     </ul>
     <?php $this->template_js = array('session') ?>

    <?php function htmlLinks($arr_links, $arr_key = "") { ?> 
        <?php $basicFunctions = new BasicFunctions(); ?>
        <?php if ($arr_links['type'] === 'link') : ?>
            <!-- Sidebar - Link -->
            <li class="nav-item <?= $basicFunctions->navbarActive(false) ?>">
                <?php $basicFunctions->navbarActive($arr_links['href']); ?>
                <a class="nav-link" href=<?= $arr_links['href'] ?>>
                    <?= isset($arr_links['icon']) ? sprintf('<i class="%s"></i>', $arr_links['icon']) : ""; ?>
                    <span><?= $arr_links['text'] ?></span>
                </a>
            </li>
        <?php endif ?>
        <?php if ($arr_links['type'] === 'links') : ?>
                 <!-- Nav Item - Pages Collapse Menu -->
                 <li class="nav-item">
                     <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse<?= $arr_key ?>" aria-expanded="true" aria-controls="collapseTwo">
                         <?= isset($value_nav['icon']) ? sprintf('<i class="%s"></i>', $value_nav['icon']) : ""; ?>
                         <span><?= $arr_links['text'] ?></span>
                     </a>
                     <div id="collapse<?= $arr_key ?>" class="collapse" aria-labelledby="heading<?= $arr_key ?>" data-parent="#accordionSidebar">
                         <div class="bg-white py-2 collapse-inner rounded">
                             <?php foreach ($arr_links['sub_itens'] as $value_sub) : ?>
                                <?php if (empty($value_sub)) {continue;} ?>
                                 <?php if ($value_sub['type'] === 'title') : ?>
                                     <div class="collapse-divider"></div>
                                     <h6 class="collapse-header"><?= $value_sub['text'] ?></h6>
                                 <?php endif ?>
                                 <?php if ($value_sub['type'] === 'link') : ?>
                                     <a class="collapse-item" href="<?= $value_sub['href'] ?>"><?= $value_sub['text'] ?></a>
                                 <?php endif ?>
                             <?php endforeach ?>
                         </div>
                     </div>
                 </li>
             <?php endif ?>        
    <?php } ?>                        

     <!-- Sidebar ORIGINAL -->
     <!-- <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"> -->
     <!-- Nav Item - Dashboard -->
     <!-- <li class="nav-item active">
             <a class="nav-link" href="index.html">
                 <i class="fas fa-fw fa-tachometer-alt"></i>
                 <span>Dashboard</span></a>
         </li> -->

     <!-- Divider -->
     <!-- <hr class="sidebar-divider"> -->

     <!-- Heading -->
     <!-- <div class="sidebar-heading">
             Interface
         </div> -->

     <!-- Nav Item - Pages Collapse Menu -->
     <!-- <li class="nav-item">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                 <i class="fas fa-fw fa-cog"></i>
                 <span>Components</span>
             </a>
             <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <h6 class="collapse-header">Custom Components:</h6>
                     <a class="collapse-item" href="buttons.html">Buttons</a>
                     <a class="collapse-item" href="cards.html">Cards</a>
                 </div>
             </div>
         </li> -->

     <!-- Nav Item - Utilities Collapse Menu -->
     <!-- <li class="nav-item">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                 <i class="fas fa-fw fa-wrench"></i>
                 <span>Utilities</span>
             </a>
             <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <h6 class="collapse-header">Custom Utilities:</h6>
                     <a class="collapse-item" href="utilities-color.html">Colors</a>
                     <a class="collapse-item" href="utilities-border.html">Borders</a>
                     <a class="collapse-item" href="utilities-animation.html">Animations</a>
                     <a class="collapse-item" href="utilities-other.html">Other</a>
                 </div>
             </div>
         </li> -->

     <!-- Divider -->
     <!-- <hr class="sidebar-divider"> -->

     <!-- Heading -->
     <!-- <div class="sidebar-heading">
             Addons
         </div> -->

     <!-- Nav Item - Pages Collapse Menu -->
     <!-- <li class="nav-item">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                 <i class="fas fa-fw fa-folder"></i>
                 <span>Pages</span>
             </a>
             <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <h6 class="collapse-header">Login Screens:</h6>
                     <a class="collapse-item" href="login.html">Login</a>
                     <a class="collapse-item" href="register.html">Register</a>
                     <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                     <div class="collapse-divider"></div>
                     <h6 class="collapse-header">Other Pages:</h6>
                     <a class="collapse-item" href="404.html">404 Page</a>
                     <a class="collapse-item" href="blank.html">Blank Page</a>
                 </div>
             </div>
         </li> -->

     <!-- Nav Item - Charts -->
     <!-- <li class="nav-item">
             <a class="nav-link" href="charts.html">
                 <i class="fas fa-fw fa-chart-area"></i>
                 <span>Charts</span></a>
         </li> -->

     <!-- Nav Item - Tables -->
     <!-- <li class="nav-item">
             <a class="nav-link" href="tables.html">
                 <i class="fas fa-fw fa-table"></i>
                 <span>Tables</span></a>
         </li> -->

     <!-- Divider -->
     <!-- <hr class="sidebar-divider d-none d-md-block"> -->

     <!-- Sidebar Toggler (Sidebar) -->
     <!-- <div class="text-center d-none d-md-inline">
             <button class="rounded-circle border-0" id="sidebarToggle"></button>
         </div> -->

     <!-- Sidebar Message -->
     <!-- <div class="sidebar-card d-none d-lg-flex">
             <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
             <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
             <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
         </div> -->

     <!-- </ul> -->
     <!-- End of Sidebar -->
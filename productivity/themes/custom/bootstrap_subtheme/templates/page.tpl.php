<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>


<div id="dashboard" class="theme-whbl">

  <header class="navbar" id="header-navbar">
    <div class="container">
      <a class="logo navbar-btn pull-left" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>

      <div class="clearfix">
        <button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="fa fa-bars"></span>
        </button>

        <div class="nav-no-collapse" id="header-nav">
            <?php if (!empty($primary_nav)): ?>
              <?php print render($primary_nav); ?>
            <?php endif; ?>
            <?php if (!empty($secondary_nav)): ?>
              <?php print render($secondary_nav); ?>
            <?php endif; ?>
            <?php if (!empty($page['navigation'])): ?>
              <?php print render($page['navigation']); ?>
            <?php endif; ?>
<!--          <ul class="nav navbar-nav pull-left">-->
<!--            <li class="dropdown" ng-show="companies.length > 1">-->
<!--              <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ company.label }} <span class="caret"></span></a>-->
<!--              <ul class="dropdown-menu" role="menu">-->
<!--                <li ng-repeat="company in companies">-->
<!--                  <a ui-sref="dashboard.campaigns.summary.by-day({ companyId: company.id, campaignId: campaignId })">{{ company.label }}</a>-->
<!--                </li>-->
<!--              </ul>-->
<!--            </li>-->
<!---->
<!--            <li class="dropdown hidden-xs" ng-show="isManager && notifications.length">-->
<!--              <a class="btn dropdown-toggle" data-toggle="dropdown">-->
<!--                <i class="fa fa-warning"></i>-->
<!--                <span class="count">2</span>-->
<!--              </a>-->
<!--              <ul class="dropdown-menu notifications-list">-->
<!--                <li class="pointer">-->
<!--                  <div class="pointer-inner">-->
<!--                    <div class="arrow"></div>-->
<!--                  </div>-->
<!--                </li>-->
<!--                <li class="item-header">2 new notifications</li>-->
<!--                <li class="item">-->
<!--                  <a>-->
<!--                    <i class="fa fa-edit"></i>-->
<!--                    <span class="content">Campaign change</span>-->
<!--                    <span class="time"><i class="fa fa-clock-o"></i>12 min.</span>-->
<!--                  </a>-->
<!--                </li>-->
<!--                <li class="item">-->
<!--                  <a>-->
<!--                    <i class="fa fa-edit"></i>-->
<!--                    <span class="content">Campaign change</span>-->
<!--                    <span class="time"><i class="fa fa-clock-o"></i>13 min.</span>-->
<!--                  </a>-->
<!--                </li>-->
<!--                <li class="item-footer">-->
<!--                  <a ui-sref="dashboard.notifications">-->
<!--                    View all notifications-->
<!--                  </a>-->
<!--                </li>-->
<!--              </ul>-->
<!--            </li>-->
<!---->
<!--            <li class="dropdown profile-dropdown">-->
<!--              <a ui-sref="dashboard.account" title="My account">-->
<!--                <img ng-src="{{ account.picture }}" alt=""><span class="hidden-xs">{{ account.label }}</span>-->
<!--              </a>-->
<!--            </li>-->
<!---->
<!--            <li>-->
<!--              <a href ng-click="logout()">-->
<!--                <i class="fa fa-power-off"></i>-->
<!--              </a>-->
<!--            </li>-->
<!--          </ul>-->

        </div>
      </div>
    </div>
  </header>

  <div id="page-wrapper" class="container fixed-footer" ng-class="{ 'nav-small': compactSidebar }">

    <div class="row">
      <div id="nav-col">
        <section id="col-left" class="col-left-nano">
          <div id="col-left-inner" class="col-left-nano-content">
            <div id="user-left-box" class="clearfix hidden-sm hidden-xs">
              <div class="user-box">
                <span class="name">Welcome<br><?php if($user->uid) { print $user->name; } ?></span>
              </div>
            </div>
            <!-- Menu -->
            <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
              <ul class="nav nav-pills nav-stacked">

                <li class="active">
                  <a class="dropdown-toggle" data-target=".submenu.reports" data-toggle="collapse">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Reports</span>
                    <i class="fa fa-chevron-circle-right drop-icon"></i>
                  </a>
                  <ul class="submenu reports collapse">
                    <li>
                      <a href="/admin/content/project-monthly-report">Monthly report</a>
                    </li>
                    <li>
                      <a ui-sref="dashboard.campaigns.content({ companyId: company.id, campaignId: campaignId })" ui-sref-active="active">Top Campaign Content</a>
                    </li>
                    <li>
                      <a ui-sref="dashboard.campaigns.management({ companyId: company.id })" ui-sref-active="active">Campaign Management</a>
                    </li>
                  </ul>
                </li>

              </ul>
            </div>
          </div>
        </section>
      </div>

      <div id="content-wrapper">

        <div class="main-container container">

          <header role="banner" id="page-header">
            <?php if (!empty($site_slogan)): ?>
              <p class="lead"><?php print $site_slogan; ?></p>
            <?php endif; ?>

            <?php print render($page['header']); ?>
          </header> <!-- /#page-header -->

          <div class="row">

            <?php if (!empty($page['sidebar_first'])): ?>
              <aside class="col-sm-3" role="complementary">
                <?php print render($page['sidebar_first']); ?>
              </aside>  <!-- /#sidebar-first -->
            <?php endif; ?>

            <section<?php print $content_column_class; ?>>
              <?php if (!empty($page['highlighted'])): ?>
                <div class="highlighted jumbotron"><?php print render($page['highlighted']); ?></div>
              <?php endif; ?>
              <?php if (!empty($breadcrumb)): print $breadcrumb; endif;?>
              <a id="main-content"></a>
              <?php print render($title_prefix); ?>
              <?php if (!empty($title)): ?>
                <h1 class="page-header"><?php print $title; ?></h1>
              <?php endif; ?>
              <?php print render($title_suffix); ?>
              <?php print $messages; ?>
              <?php if (!empty($tabs)): ?>
                <?php print render($tabs); ?>
              <?php endif; ?>
              <?php if (!empty($page['help'])): ?>
                <?php print render($page['help']); ?>
              <?php endif; ?>
              <?php if (!empty($action_links)): ?>
                <ul class="action-links"><?php print render($action_links); ?></ul>
              <?php endif; ?>
              <?php print render($page['content']); ?>
            </section>

            <?php if (!empty($page['sidebar_second'])): ?>
              <aside class="col-sm-3" role="complementary">
                <?php print render($page['sidebar_second']); ?>
              </aside>  <!-- /#sidebar-second -->
            <?php endif; ?>

          </div>
        </div>

        <footer id="footer-bar" class="row">
          <p id="footer-copyright" class="col-xs-12">© 2015 <a href="#">Gizra Productivity</a>.</p>
          <?php print render($page['footer']); ?>
        </footer>
      </div>
    </div>
  </div>
</div>

<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark bg-orange">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="/" class="navbar-brand navbar-brand-autodark">
            <div style="color: rgba(255,255,255,.72);" class="text-center if-desktop">
                <img class="mb-1" src="/resources/img/logo.png" style="height: 32px; display: block;">
                WEB FRAMEWORK
            </div>
        </a>

        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">
                <?php foreach ($this->data->subnav as $top) { ?>
                    <?php
                    if (isset($top["item"])) {
                        foreach ($top["item"] as $sub) {
                            $is_active = $this->request->match($sub["pattern"]) ? 'active' : '';
                            if ($is_active == 'active') break;
                        }
                    ?>
                        <li class="nav-item <?= $is_active ?> dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="<?= $is_active == 'active' ? 'true' : 'false' ?>">
                                <span class="nav-link-title">
                                    <i class="<?= $top["icon"] ?>" style="margin-right: 4px;"></i> <?= $top["title"] ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu <?= $is_active == 'active' ? 'show' : '' ?>">
                                <?php foreach ($top["item"] as $sub) { ?>
                                    <li>
                                        <a class="dropdown-item <?= $this->request->match($sub["pattern"]) ? 'active bg-orange-lt' : '' ?>" href="<?= $sub["link"] ?>">
                                            <?= $sub["title"]; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item <?= $this->request->match($top["pattern"]) ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= $top["link"] ?>">
                                <span class="nav-link-title">
                                    <i class="<?= $top["icon"] ?>" style="margin-right: 4px;"></i> <?= $top["title"] ?>
                                </span>
                            </a>
                        </li>

                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
</aside>
<?php
/*
 * This file is part of the Sulu Securitytxt bundle.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace BitExpert\Sulu\SecuritytxtBundle\Admin;

use BitExpert\Sulu\SecuritytxtBundle\Entity\Securitytxt;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItem;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItemCollection;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Bundle\AdminBundle\Exception\NavigationItemNotFoundException;
use Sulu\Bundle\PageBundle\Admin\PageAdmin;
use Sulu\Bundle\WebsiteBundle\Entity\AnalyticsInterface;
use Sulu\Component\Security\Authorization\PermissionTypes;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;

class SecuritytxtAdmin extends Admin
{
    final public const SECURITY_CONTEXT = 'bitexpert.securitytxt';

    final public const SECURITYTXT_LIST_KEY = 'securitytxt';
    final public const SECURITYTXT_LIST_VIEW = 'app.securitytxt_list';

    public function __construct(
        private readonly ViewBuilderFactoryInterface $viewBuilderFactory,
        private readonly SecurityCheckerInterface    $securityChecker
    ) {
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        $toolbarActions = [];

        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::ADD)) {
            $toolbarActions[] = new ToolbarAction('sulu_admin.add');
        }

        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::DELETE)) {
            $toolbarActions[] = new ToolbarAction('sulu_admin.delete');
        }

        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::VIEW)) {
            $viewCollection->add(
                $this->viewBuilderFactory
                    ->createFormOverlayListViewBuilder(static::SECURITYTXT_LIST_VIEW, '/securitytxt')
                    ->setResourceKey(Securitytxt::RESOURCE_KEY)
                    ->setListKey(self::SECURITYTXT_LIST_KEY)
                    ->addListAdapters(['table'])
                    ->addAdapterOptions(['table' => ['skin' => 'light']])
                    ->addRouterAttributesToListRequest(['webspace'])
                    ->addRouterAttributesToFormRequest(['webspace'])
                    ->disableSearching()
                    ->setFormKey('securitytxt_details')
                    ->setTabTitle('securitytxt.title')
                    ->setTabOrder(2048)
                    ->addToolbarActions($toolbarActions)
                    ->setParent(PageAdmin::WEBSPACE_TABS_VIEW)
                    ->addRerenderAttribute('webspace')
            );
        }
    }

    public function getSecurityContexts()
    {
        return [
            'BitExpert' => [
                'Securitytxt' => [
                    static::SECURITY_CONTEXT => [
                        PermissionTypes::VIEW,
                        PermissionTypes::ADD,
                        PermissionTypes::DELETE,
                    ],
                ],
            ],
        ];
    }

    public function getConfigKey(): ?string
    {
        return 'bitexpert.securitytxt';
    }
}

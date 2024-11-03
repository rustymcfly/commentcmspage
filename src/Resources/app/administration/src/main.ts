const {Service, Component} = Shopware

Component.override('sw-category-detail-base', () => import('./module/sw-category/views/sw-category-detail'))
Component.override('sw-flow-mail-send-modal', () => import('./module/sw-flow/component/modals/sw-flow-mail-send-modal'))
Component.register('sw-cms-el-component-comments', () => import('./module/sw-cms/elements/comments/component'))
Component.register('sw-cms-el-preview-comments', () => import('./module/sw-cms/elements/comments/preview'))

Service('cmsService').registerCmsElement({
    name: 'comments',
    label: 'sw-cms.elements.comments.label',
    component: 'sw-cms-el-component-comments',
    previewComponent: 'sw-cms-el-preview-comments',
    defaultConfig: {},
    defaultData: {
        comments: [
            {
                comment: 'Lorem Ipsum',
                firstName: 'John',
                lastName: 'Doe',
                createdAt: new Date(),
            },
            {
                comment: 'Lorem Ipsum',
                firstName: 'John',
                lastName: 'Doe',
                createdAt: new Date(),
            }
        ]
    }
});

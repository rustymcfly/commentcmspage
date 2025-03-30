import template from './sw-cms-el-component-comments.html.twig';
import './sw-cms-el-component-comments.scss';

const {Mixin} = Shopware;

export default {
    template,
    props: {
        element: {
            type: Object,
            required: true
        }
    },
    mixins: [
        Mixin.getByName('cms-element')
    ],

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('comments');
            this.initElementData('comments');
        },
    },
}

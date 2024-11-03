import template from './sw-cms-el-component-comments.html.twig';
import './sw-cms-el-component-comments.scss';

const { Mixin} = Shopware;

export default {
  template,

  mixins: [
    Mixin.getByName('cms-element')
  ],

  created() {
    console.log(element.data)
    this.createdComponent();
  },

  methods: {
    createdComponent() {
      this.initElementConfig('comments');
      this.initElementData('comments');
    },
  },
}

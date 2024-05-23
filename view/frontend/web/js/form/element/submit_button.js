define([
    'jquery',
    'Magento_Ui/js/form/components/button',
    'uiRegistry',
    'mageUtils'
], function ($, button, registry, utils) {
    'use strict';

    return button.extend({

        /**
         * Apply ajax action on target component
         */
        applyAction: function (action) {
            var targetName = action.targetName,
                params = utils.copy(action.params) || [],
                actionName = action.actionName,
                target;

            if (!registry.has(targetName)) {
                this.getFromTemplate(targetName);
            }
            target = registry.async(targetName);

            if (target && typeof target === 'function' && actionName) {
                params.unshift(actionName);
                target.apply(target, params);
            }
            registry.get('testimonials_listing.testimonials_listing_data_source').set('params.t ', Date.now());
            registry.get('testimonials_form.testimonials_form').reset();
        },
    });
});

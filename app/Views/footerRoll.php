<script>
if (typeof(jQuery) == "undefined") {
    window.jQuery = function (selector) { return parent.jQuery(selector, document); };
    jQuery = parent.$.extend(jQuery, parent.$);
    window.$ = jQuery;
}
</script>

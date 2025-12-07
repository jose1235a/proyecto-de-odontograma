<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-save');
    if (!form) return;

    const locale = window.location.pathname.split('/')[1];
    const supportedLocales = ['es', 'pt', 'en', 'fr', 'it'];

    const parsleyScript = document.createElement('script');
    parsleyScript.src = "<?php echo e(asset('adminlte/plugins/parsley/js/parsley.min.js')); ?>";

    parsleyScript.onload = function () {
      if (supportedLocales.includes(locale)) {
        const localeScript = document.createElement('script');
        localeScript.src = `/adminlte/plugins/parsley/js/i18n/${locale}.js`;
        localeScript.onload = function () {
          Parsley.setLocale(locale);
        };
        document.head.appendChild(localeScript);
      }

      // Configuración global Parsley ajustada
      window.ParsleyConfig = {
        errorsContainer: function (field) {
          // Si el input está dentro de un input-group
          const ig = field.$element.closest('.input-group');
          if (ig.length) {
            if (ig.parent().find('.parsley-errors-container').length === 0) {
              ig.parent().append('<div class="parsley-errors-container"></div>');
            }
            return ig.parent().find('.parsley-errors-container');
          }
          // Si no hay input-group
          return field.$element.parent();
        },
        errorsWrapper: '<ul class="parsley-errors-list list-unstyled mt-1 mb-0"></ul>',
        errorTemplate: '<li class="text-danger small"></li>'
      };

      const $form = $('#form-save');
      $form.parsley();

      window.submitWithParsley = function () {
        if ($form.parsley().validate()) {
          $form.submit();
        }
      };
    };

    document.head.appendChild(parsleyScript);
  });
</script>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/layouts/plugins/parsley.blade.php ENDPATH**/ ?>
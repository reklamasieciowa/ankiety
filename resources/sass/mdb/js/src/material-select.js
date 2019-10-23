(function ($) {

  class MaterialSelect {

    constructor($nativeSelect, options) {

      this.$nativeSelect = $nativeSelect;

      this.defaults = {
        destroy: false,
        nativeID: null,
        BSsearchIn: false,
        BSinputText: false,
        fasClasses: '',
        farClasses: '',
        fabClasses: '',
        copyClassesOption: false,
        language: {
          active: false,
          pl: {
            selectAll: 'Wybierz wszystko',
            optionsSelected: 'wybranych opcji'
          },
          in: {
            selectAll: 'Pilih semuanya',
            optionsSelected: 'opsi yang dipilih'
          },
          fr: {
            selectAll: 'Tout choisir',
            optionsSelected: 'options sélectionnées'
          },
          ge: {
            selectAll: 'Wähle alles aus',
            optionsSelected: 'ausgewählte Optionen'
          },
          ar: {
            selectAll: 'اختر كل شيء',
            optionsSelected: 'الخيارات المحددة'
          }
        }
      };

      this.options = this.assignOptions(options);

      this.isMultiple = Boolean(this.$nativeSelect.attr('multiple'));
      this.isSearchable = Boolean(this.$nativeSelect.attr('searchable'));
      this.isRequired = Boolean(this.$nativeSelect.attr('required'));
      this.isEditable = Boolean(this.$nativeSelect.attr('editable'));

      this.selectAllLabel = Boolean(this.$nativeSelect.attr('selectAllLabel')) ? this.$nativeSelect.attr('selectAllLabel') : 'Select all';
      this.optionsSelectedLabel = Boolean(this.$nativeSelect.attr('optionsSelectedLabel')) ? this.$nativeSelect.attr('optionsSelectedLabel') : 'options selected';
      this.keyboardActiveClass = Boolean(this.$nativeSelect.attr('keyboardActiveClass')) ? this.$nativeSelect.attr('keyboardActiveClass') : 'heavy-rain-gradient';

      this.uuid = this.options.nativeID !== null && this.options.nativeID !== '' && this.options.nativeID !==
        undefined && typeof this.options.nativeID === 'string' ? this.options.nativeID : this._randomUUID();
      this.$selectWrapper = $('<div class="select-wrapper"></div>');
      this.$materialOptionsList = $(`<ul id="select-options-${this.uuid}" class="dropdown-content select-dropdown w-100 ${this.isMultiple ? 'multiple-select-dropdown' : ''}"></ul>`);
      this.$materialSelectInitialOption = $nativeSelect.find('option:selected').text() || $nativeSelect.find('option:first').text() || '';
      this.$nativeSelectChildren = this.$nativeSelect.children('option, optgroup');
      this.$materialSelect = $(`<input type="text" class="${this.options.BSinputText ? 'browser-default custom-select multi-bs-select select-dropdown form-control' : 'select-dropdown form-control'}" ${!this.options.validate && 'readonly="true"'} required="${this.options.validate ? 'true' : 'false'}" ${this.$nativeSelect.is(' :disabled') ? 'disabled' : ''} data-activates="select-options-${this.uuid}" value=""/>`);
      this.$dropdownIcon = this.options.BSinputText ? '' : $('<span class="caret">&#9660;</span>');
      this.$searchInput = null;
      this.$toggleAll = $(`<li class="select-toggle-all"><span><input type="checkbox" class="form-check-input"><label>${this.selectAllLabel}</label></span></li>`);
      this.$addOptionBtn = $('<i class="select-add-option fas fa-plus"></i>');
      this.mainLabel = this.$nativeSelect.next('.mdb-main-label');

      this.$validFeedback = $(`<div class="valid-feedback">${this.options.validFeedback || 'Good choice'}</div>`);
      this.$invalidFeedback = $(`<div class="invalid-feedback">${this.options.invalidFeedback || 'Bad choice'}</div>`);

      this.valuesSelected = [];
      this.keyCodes = {
        tab: 9,
        esc: 27,
        enter: 13,
        arrowUp: 38,
        arrowDown: 40
      };

      MaterialSelect.mutationObservers = [];
    }

    static clearMutationObservers() {

      MaterialSelect.mutationObservers.forEach((observer) => {

        observer.disconnect();
        observer.customStatus = 'stopped';
      });
    }

    assignOptions(newOptions) {

      return $.extend({}, this.defaults, newOptions);
    }

    init() {

      const alreadyInitialized = Boolean(this.$nativeSelect.data('select-id'));
      if (alreadyInitialized) {

        this._removeMaterialWrapper();
      }

      if (this.options.destroy) {

        const $btnSave = this.$nativeSelect.parent().find('button.btn-save').length ? this.$nativeSelect.parent().find('button.btn-save') : false;
        this.$nativeSelect.data('select-id', null).removeClass('initialized');
        this.$nativeSelect.parent().append($btnSave);
        
        return;
      }

      if (this.options.BSsearchIn || this.options.BSinputText) {

        this.$selectWrapper.addClass(this.$nativeSelect.attr('class').split(' ').filter(el => el !== 'md-form').join(' ')).css({
          marginTop: '1.5rem',
          marginBottom: '1.5rem'
        });

      } else {
        this.$selectWrapper.addClass(this.$nativeSelect.attr('class'));
      }

      this.$nativeSelect.data('select-id', this.uuid);

      const sanitizedLabelHtml = this.$materialSelectInitialOption.replace(/"/g, '&quot;').replace(/  +/g, ' ').trim();

      this.mainLabel.length === 0 ? this.$materialSelect.val(sanitizedLabelHtml) : this.mainLabel.text();

      this.renderMaterialSelect();
      this.bindEvents();

      if (this.isRequired) {

        this.enableValidation();
      }

      if (this.options.language.active && this.$toggleAll) {

        if (this.options.language.pl) {

          this.$toggleAll.find('label').text(this.options.language.pl.selectAll ? this.options.language.pl.selectAll : this.defaults.language.pl.selectAll);
        }
        if (this.options.language.fr) {

          this.$toggleAll.find('label').text(this.options.language.fr.selectAll ? this.options.language.fr.selectAll : this.defaults.language.fr.selectAll);
        }
        if (this.options.language.ge) {

          this.$toggleAll.find('label').text(this.options.language.ge.selectAll ? this.options.language.ge.selectAll : this.defaults.language.ge.selectAll);
        }
        if (this.options.language.ar) {

          this.$toggleAll.find('label').text(this.options.language.ar.selectAll ? this.options.language.ar.selectAll : this.defaults.language.ar.selectAll);
        }
        if (this.options.language.in) {

          this.$toggleAll.find('label').text(this.options.language.in.selectAll ? this.options.language.in.selectAll : this.defaults.language.in.selectAll);
        }
      }

      if (this.$materialSelect.hasClass('custom-select') && this.$materialSelect.hasClass('select-dropdown')) {

        this.$materialSelect.css({
          display: 'inline-block',
          width: '100%',
          height: 'calc(1.5em + .75rem + 2px)',
          padding: '.375rem 1.75rem .375rem .75rem',
          fontSize: '1rem',
          lineHeight: '1.5',
          backgroundColor: '#fff',
          border: '1px solid #ced4da'
        });
      }
    }

    _removeMaterialWrapper() {

      const currentUuid = this.$nativeSelect.data('select-id');

      this.$nativeSelect.parent().find('span.caret').remove();
      this.$nativeSelect.parent().find('input').remove();
      this.$nativeSelect.unwrap();

      $(`ul#select-options-${currentUuid}`).remove();
    }

    renderMaterialSelect() {

      this.$nativeSelect.before(this.$selectWrapper);

      this.appendDropdownIcon();
      this.appendValidation();
      this.appendMaterialSelect();
      this.appendMaterialOptionsList();
      this.appendNativeSelect();
      this.appendSaveSelectButton();

      if (!this.$nativeSelect.is(':disabled')) {

        this.$materialSelect.dropdown({
          hover: false,
          closeOnClick: false
        });

      }

      if (this.$nativeSelect.data('inherit-tabindex') !== false) {

        this.$materialSelect.attr('tabindex', this.$nativeSelect.attr('tabindex'));
      }

      if (this.isMultiple) {

        this.$nativeSelect.find('option:selected:not(:disabled)').each((i, element) => {

          const index = element.index;
          this._toggleSelectedValue(index);
          this.$materialOptionsList.find('li:not(.optgroup):not(.select-toggle-all)').eq(index).find(':checkbox').prop('checked', true);
        });
      } else {
   
        const preselectedOption = this.$nativeSelect.find('option[selected]').first();
        const indexOfPreselectedOption = this.$nativeSelect.find('option').index(preselectedOption.get(0));
        if (preselectedOption.attr('disabled') !== 'disabled' && indexOfPreselectedOption >= 0) {
          this._toggleSelectedValue(indexOfPreselectedOption);
        }
      }

      this.$nativeSelect.addClass('initialized');

      if (this.options.BSinputText) {

        this.mainLabel.css('top', '-7px');
      }
    }

    appendDropdownIcon() {

      if (this.$nativeSelect.is(':disabled')) {

        this.$dropdownIcon.addClass('disabled');
      }

      this.$selectWrapper.append(this.$dropdownIcon);
    }

    appendValidation() {
      if (this.options.validate) {
        this.$validFeedback.insertAfter(this.$selectWrapper);
        this.$invalidFeedback.insertAfter(this.$selectWrapper);
      }
    }

    appendMaterialSelect() {

      this.$selectWrapper.append(this.$materialSelect);
    }

    appendMaterialOptionsList() {

      if (this.isSearchable) {

        this.appendSearchInputOption();
      }

      if (this.isEditable && this.isSearchable) {

        this.appendAddOptionBtn();
      }

      this.buildMaterialOptions();

      if (this.isMultiple) {

        this.appendToggleAllCheckbox();
      }

      this.$selectWrapper.append(this.$materialOptionsList);
    }

    appendNativeSelect() {

      this.$nativeSelect.appendTo(this.$selectWrapper);
    }

    appendSearchInputOption() {

      const placeholder = this.$nativeSelect.attr('searchable');

      if (this.options.BSsearchIn) {

        this.$searchInput = $(`<span class="search-wrap ml-2"><div class="mt-0"><input type="text" class="search mb-2 w-100 d-block select-default" tabindex="-1" placeholder="${placeholder}"></div></span>`);
      } else {

        this.$searchInput = $(`<span class="search-wrap ml-2"><div class="md-form mt-0"><input type="text" class="search w-100 d-block" tabindex="-1" placeholder="${placeholder}"></div></span>`);
      }

      this.$materialOptionsList.append(this.$searchInput);
      this.$searchInput.on('click', e => {
        e.stopPropagation();
      });
    }

    appendAddOptionBtn() {
      this.$searchInput.append(this.$addOptionBtn);
      this.$addOptionBtn.on('click', this.addNewOption.bind(this));
    }

    addNewOption() {
      let val = this.$searchInput.find('input').val();
      let $newOption = $(`<option value="${val.toLowerCase()}" selected>${val}</option>`).prop('selected', true);
      if (!this.isMultple) {
        this.$nativeSelectChildren.each((index, option) => {
          $(option).attr('selected', false);
        });
      };
      this.$nativeSelect.append($newOption);
    }

    appendToggleAllCheckbox() {

      const firstOption = this.$materialOptionsList.find('li').first();
      if (firstOption.hasClass('disabled') && firstOption.find('input').prop('disabled')) {
        firstOption.after(this.$toggleAll);
      } else {
        this.$materialOptionsList.find('li').first().before(this.$toggleAll);
      }

    }

    appendSaveSelectButton() {

      this.$selectWrapper.parent().find('button.btn-save').appendTo(this.$materialOptionsList);
    }

    buildMaterialOptions() {

      this.$nativeSelectChildren.each((index, option) => {

        const $this = $(option);

        if ($this.is('option')) {

          this.buildSingleOption($this, this.isMultiple ? 'multiple' : '');
        } else if ($this.is('optgroup')) {

          const $materialOptgroup = $(`<li class="optgroup"><span>${$this.attr('label')}</span></li>`);
          this.$materialOptionsList.append($materialOptgroup);

          const $optgroupOptions = $this.children('option');
          $optgroupOptions.each((index, optgroupOption) => {

            this.buildSingleOption($(optgroupOption), 'optgroup-option');
          });
        }
      });
    }

    buildSingleOption($nativeSelectChild, type) {

      const disabled = $nativeSelectChild.is(':disabled') ? 'disabled' : '';
      const optgroupClass = type === 'optgroup-option' ? 'optgroup-option' : '';
      const iconUrl = $nativeSelectChild.data('icon');
      const fas = $nativeSelectChild.data('fas') ? `<i class="fa-pull-right m-2 fas fa-${$nativeSelectChild.data('fas')} ${[...this.options.fasClasses].join('')}"></i> ` : '';
      const far = $nativeSelectChild.data('far') ? `<i class="fa-pull-right m-2 far fa-${$nativeSelectChild.data('far')} ${[...this.options.farClasses].join('')}"></i> ` : '';
      const fab = $nativeSelectChild.data('fab') ? `<i class="fa-pull-right m-2 fab fa-${$nativeSelectChild.data('fab')} ${[...this.options.fabClasses].join('')}"></i> ` : '';

      const classes = $nativeSelectChild.attr('class');

      const iconHtml = iconUrl ? `<img alt="" src="${iconUrl}" class="${classes}">` : '';
      const checkboxHtml = this.isMultiple ? `<input type="checkbox" class="form-check-input" ${disabled}/><label></label>` : '';

      this.$materialOptionsList.append($(`<li class="${disabled} ${optgroupClass} ${this.options.copyClassesOption ? classes : ''} ">${iconHtml}<span class="filtrable">${checkboxHtml} ${$nativeSelectChild.html()} ${fas} ${far} ${fab}</span></li>`));
    }

    enableValidation() {

      this.$nativeSelect.css({
        position: 'absolute',
        top: '1rem',
        left: '0',
        height: '0',
        width: '0',
        opacity: '0',
        padding: '0',
        'pointer-events': 'none'
      });

      if (this.$nativeSelect.attr('style').indexOf('inline!important') === -1) {

        this.$nativeSelect.attr('style', `${this.$nativeSelect.attr('style')} display: inline!important;`);
      }

      this.$nativeSelect.attr('tabindex', -1);
      this.$nativeSelect.data('inherit-tabindex', false);
    }

    bindEvents() {

      const config = {
        attributes: true,
        childList: true,
        characterData: true,
        subtree: true
      };
      const observer = new MutationObserver(this._onMutationObserverChange.bind(this));
      observer.observe(this.$nativeSelect.get(0), config);
      observer.customId = this.uuid;
      observer.customStatus = 'observing';

      MaterialSelect.clearMutationObservers();
      MaterialSelect.mutationObservers.push(observer);

      const $saveSelectBtn = this.$nativeSelect.parent().find('button.btn-save');

      $saveSelectBtn.on('click', this._onSaveSelectBtnClick.bind(this));

      this.$materialSelect.on('focus', this._onMaterialSelectFocus.bind(this));
      this.$materialSelect.on('click', this._onMaterialSelectClick.bind(this));
      this.$materialSelect.on('blur', this._onMaterialSelectBlur.bind(this));
      this.$materialSelect.on('keydown', this._onMaterialSelectKeydown.bind(this));

      this.$toggleAll.on('click', this._onToggleAllClick.bind(this));

      this.$materialOptionsList.on('mousedown', this._onEachMaterialOptionMousedown.bind(this));
      this.$materialOptionsList.find('li:not(.optgroup)').not(this.$toggleAll).each((materialOptionIndex, materialOption) => {
        $(materialOption).on('click', this._onEachMaterialOptionClick.bind(this, materialOptionIndex, materialOption));
      });

      if (!this.isMultiple && this.isSearchable) {

        this.$materialOptionsList.find('li').on('click', this._onSingleMaterialOptionClick.bind(this));
      }

      if (this.isSearchable) {

        this.$searchInput.find('.search').on('keyup', this._onSearchInputKeyup.bind(this));
      }

      $('html').on('click', this._onHTMLClick.bind(this));
    }

    _onMutationObserverChange(mutationsList) {

      mutationsList.forEach((mutation) => {

        const $select = $(mutation.target).closest('select');
        if ($select.data('stop-refresh') !== true && (mutation.type === 'childList' || mutation.type === 'attributes' && $(mutation.target).is('option'))) {

          MaterialSelect.clearMutationObservers();

          $select.materialSelect({
            destroy: true
          });
          $select.materialSelect();
        }
      });
    }

    _onSaveSelectBtnClick() {

      $('input.multi-bs-select').trigger('close');
      this.$materialOptionsList.hide();
      this.$materialSelect.removeClass('active');
    }

    _onEachMaterialOptionClick(materialOptionIndex, materialOption, e) {

      e.stopPropagation();

      const $this = $(materialOption);

      if ($this.hasClass('disabled') || $this.hasClass('optgroup')) {

        return;
      }

      let selected = true;

      if (this.isMultiple) {

        $this.find('input[type="checkbox"]').prop('checked', (index, oldPropertyValue) => {

          return !oldPropertyValue;
        });

        const hasOptgroup = Boolean(this.$nativeSelect.find('optgroup').length);
        const thisIndex = this._isToggleAllPresent() ? $this.index() - 1 : $this.index();

        if (this.isSearchable && hasOptgroup) {

          selected = this._toggleSelectedValue(thisIndex - $this.prevAll('.optgroup').length - 1);
        } else if (this.isSearchable) {

          selected = this._toggleSelectedValue(thisIndex - 1);
        } else if (hasOptgroup) {

          selected = this._toggleSelectedValue(thisIndex - $this.prevAll('.optgroup').length);
        } else {

          selected = this._toggleSelectedValue(thisIndex);
        }

        if (this._isToggleAllPresent()) {

          this._updateToggleAllOption();
        }

        this.$materialSelect.trigger('focus');
      } else {

        this.$materialOptionsList.find('li').removeClass('active');
        $this.toggleClass('active');
        this.$materialSelect.val($this.text().replace(/  +/g, ' ').trim());
        this.$materialSelect.trigger('close');
      }

      this._selectSingleOption($this);
      this.$nativeSelect.data('stop-refresh', true);
      this.$nativeSelect.find('option').eq(materialOptionIndex).prop('selected', selected);
      this.$nativeSelect.removeData('stop-refresh');
      this._triggerChangeOnNativeSelect();

      if (this.mainLabel.prev().find('input').hasClass('select-dropdown')) {

        if (this.mainLabel.prev().find('input.select-dropdown').val().length > 0) {

          this.mainLabel.addClass('active');
        }
      }

      if (typeof this.options === 'function') {

        this.options();
      }

      if ($this.hasClass('li-added')) {

        this.$materialOptionsList.append(this.buildSingleOption($this, ''));
      }
    }

    _escapeKeyboardActiveOptions() {
      this.$materialOptionsList.find('li').each((i, el) => {
        $(el).removeClass(this.keyboardActiveClass)
      });
    }

    _triggerChangeOnNativeSelect() {

      const keyboardEvt = new KeyboardEvent('change', {
        bubbles: true,
        cancelable: true
      });
      this.$nativeSelect.get(0).dispatchEvent(keyboardEvt);
    }

    _onMaterialSelectFocus(e) {

      const $this = $(e.target);

      if ($('ul.select-dropdown').not(this.$materialOptionsList.get(0)).is(':visible')) {

        $('input.select-dropdown').trigger('close');
      }

      this.mainLabel.addClass('active');

      if (!this.$materialOptionsList.is(':visible')) {

        $this.trigger('open', ['focus']);
        const label = $this.val();
        const $selectedOption = this.$materialOptionsList.find('li').filter(function () {

          return $(this).text().toLowerCase() === label.toLowerCase();
        })[0];

        this._selectSingleOption($selectedOption);
      }

      if (!this.isMultiple) {

        this.mainLabel.addClass('active');
      }

      $(document).find('input.select-dropdown').each((i, el) => $(el).val().length <= 0).parent().next('.mdb-main-label')
        .filter((i, el) => {

          return $(el).prev().find('input.select-dropdown').val().length <= 0 && !$(el).prev().find('input.select-dropdown').hasClass('active');
        })
        .removeClass('active');
    }

    _onMaterialSelectClick(e) {

      this.mainLabel.addClass('active');
      e.stopPropagation();
    }

    _onMaterialSelectBlur(e) {

      const $this = $(e);

      if (!this.isMultiple && !this.isSearchable) {

        $this.trigger('close');
      }

      this.$materialOptionsList.find('li.selected').removeClass('selected');
    }

    _onSingleMaterialOptionClick() {

      this.$materialSelect.trigger('close');
    }

    _onEachMaterialOptionMousedown(e) {

      const option = e.target;

      if ($('.modal-content').find(this.$materialOptionsList).length) {

        if (option.scrollHeight > option.offsetHeight) {

          e.preventDefault();
        }
      }

    }

    _onHTMLClick(e) {

      if (!$(e.target).closest(`#select-options-${this.uuid}`).length && !$(e.target).hasClass('mdb-select') && $(`#select-options-${this.uuid}`).hasClass('active')) {

        this.$materialSelect.trigger('close');

        if (!this.$materialSelect.val().length > 0) {

          this.mainLabel.removeClass('active');
        }
      }

      if (this.isSearchable && this.$searchInput !== null && this.$materialOptionsList.hasClass('active')) {

        this.$materialOptionsList.find('.search-wrap input.search').focus();
      }
    }
    _onToggleAllClick(e) {

      const checkbox = $(this.$toggleAll).find('input[type="checkbox"]').first();
      const state = !$(checkbox).prop('checked');

      $(checkbox).prop('checked', state);

      this.$materialOptionsList.find('li:not(.optgroup):not(.select-toggle-all)').each((materialOptionIndex, materialOption) => {

        const $optionCheckbox = $(materialOption).find('input[type="checkbox"]');

        if (state && $optionCheckbox.is(':checked') || !state && !$optionCheckbox.is(':checked') || $(materialOption).is(':hidden') || $(materialOption).is('.disabled')) {

          return;
        }

        $optionCheckbox.prop('checked', state);

        this.$nativeSelect.find('option').eq(materialOptionIndex).prop('selected', state);

        if (state) {

          $(materialOption).removeClass('active');
        } else {

          $(materialOption).addClass('active');
        }

        this._toggleSelectedValue(materialOptionIndex);
        this._selectOption(materialOption);

        this._setValueToMaterialSelect();
      });

      this.$nativeSelect.data('stop-refresh', true);
      this._triggerChangeOnNativeSelect();
      this.$nativeSelect.removeData('stop-refresh');
      e.stopPropagation();
    }
    _onMaterialSelectKeydown(e) {

      const $this = $(e.target);

      const isTab = e.which === this.keyCodes.tab;
      const isEsc = e.which === this.keyCodes.esc;
      const isEnter = e.which === this.keyCodes.enter;
      const isEnterWithShift = isEnter && e.shiftKey;
      const isArrowUp = e.which === this.keyCodes.arrowUp;
      const isArrowDown = e.which === this.keyCodes.arrowDown;

      const isMaterialSelectVisible = this.$materialOptionsList.is(':visible');
      if (isTab) {

        this._handleTabKey($this);
        return;
      } else if (isArrowDown && !isMaterialSelectVisible) {

        $this.trigger('open');
        return;
      } else if (isEnter && !isMaterialSelectVisible) {

        return;
      }

      e.preventDefault();

      if (isEnterWithShift) {

        this._handleEnterWithShiftKey($this);
      } else if (isEnter) {

        this._handleEnterKey($this);
      } else if (isArrowDown) {

        this._handleArrowDownKey();
      } else if (isArrowUp) {

        this._handleArrowUpKey();
      } else if (isEsc) {

        this._handleEscKey($this);
      } else {

        this._handleLetterKey(e);
      }
    }

    _handleTabKey(materialSelect) {

      this._handleEscKey(materialSelect);
    }

    _handleEnterWithShiftKey(materialSelect) {

      if (!this.isMultiple) {

        this._handleEnterKey(materialSelect);
      } else {

        this.$toggleAll.trigger('click');
      }
    }

    _handleEnterKey(materialSelect) {

      const $activeOption = this.$materialOptionsList.find('li.selected:not(.disabled)');

      $activeOption.trigger('click').addClass('active');

      if (!this.isMultiple) {

        $(materialSelect).trigger('close');
      }
    }

    _handleArrowDownKey() {

      const $availableOptions = this.$materialOptionsList.find('li:visible').not('.disabled, .select-toggle-all');

      const $firstOption = this.$materialOptionsList.find('li:visible').not('.disabled, .select-toggle-all').first();
      const $lastOption = this.$materialOptionsList.find('li:visible').not('.disabled, .select-toggle-all').last();
      const anySelected = this.$materialOptionsList.find('li.selected').length > 0;

      const $currentOption = anySelected ? this.$materialOptionsList.find('li.selected').first() : $firstOption;
      let $nextOption = $currentOption.next('li:visible:not(.disabled, .select-toggle-all)');
      let $activeOption = $nextOption;

      $availableOptions.each((key, el) => {
        if ($(el).hasClass(this.keyboardActiveClass)) {
          $nextOption = $availableOptions.eq(key + 1)
          $activeOption = $availableOptions.eq(key)
        }
      })

      const $matchedMaterialOption = $currentOption.is($lastOption) || !anySelected ? $currentOption : $nextOption;

      this._selectSingleOption($matchedMaterialOption);

      this._escapeKeyboardActiveOptions();

      if (!$matchedMaterialOption.find('input').is(':checked')) {

        $matchedMaterialOption.removeClass(this.keyboardActiveClass);
      }

      if (!$activeOption.hasClass('selected') && !$activeOption.find('input').is(':checked') && this.isMultiple) {

        $activeOption.removeClass('active', this.keyboardActiveClass);
      }

      $matchedMaterialOption.addClass(this.keyboardActiveClass);
      
      if ($matchedMaterialOption.position()) {
        this.$materialOptionsList.scrollTop(this.$materialOptionsList.scrollTop() + $matchedMaterialOption.position().top)
      }
    }

    _handleArrowUpKey() {

      const $availableOptions = this.$materialOptionsList.find('li:visible').not('.disabled, .select-toggle-all');

      const $firstOption = this.$materialOptionsList.find('li:visible').not('.disabled, .select-toggle-all').first();
      const $lastOption = this.$materialOptionsList.find('li:visible').not('.disabled, .select-toggle-all').last();
      const anySelected = this.$materialOptionsList.find('li.selected').length > 0;

      const $currentOption = anySelected ? this.$materialOptionsList.find('li.selected').first() : $lastOption;
      let $prevOption = $currentOption.prev('li:visible:not(.disabled, .select-toggle-all)');
      let $activeOption = $prevOption;

      $availableOptions.each((key, el) => {
        if ($(el).hasClass(this.keyboardActiveClass)) {
          $prevOption = $availableOptions.eq(key - 1)
          $activeOption = $availableOptions.eq(key)
        }
      })

      const $matchedMaterialOption = $currentOption.is($firstOption) || !anySelected ? $currentOption : $prevOption;

      this._selectSingleOption($matchedMaterialOption);

      this._escapeKeyboardActiveOptions();

      if (!$matchedMaterialOption.find('input').is(':checked')) {

        $matchedMaterialOption.removeClass(this.keyboardActiveClass);
      }

      if (!$activeOption.hasClass('selected') && !$activeOption.find('input').is(':checked') && this.isMultiple) {

        $activeOption.removeClass('active', this.keyboardActiveClass);
      }

      $matchedMaterialOption.addClass(this.keyboardActiveClass);

      if ($matchedMaterialOption.position()) {
        this.$materialOptionsList.scrollTop(this.$materialOptionsList.scrollTop() + $matchedMaterialOption.position().top)
      }
    }

    _handleEscKey(materialSelect) {

      this._escapeKeyboardActiveOptions();
      $(materialSelect).trigger('close');
    }

    _handleLetterKey(e) {

      this._escapeKeyboardActiveOptions();

      if (this.isSearchable) {
        
        const isLetter = e.which > 46 && e.which < 91
        const isNumber = e.which > 93 && e.which < 106
        const isBackspace = e.which === 8

        if (isLetter || isNumber) this.$searchInput.find('input').val(e.key).focus()
        if (isBackspace) this.$searchInput.find('input').val('').focus()

      } else {
        
        let filterQueryString = '';
        const letter = String.fromCharCode(e.which).toLowerCase();
        const nonLetters = Object.keys(this.keyCodes).map((key) => this.keyCodes[key]);
        const isLetterSearchable = letter && nonLetters.indexOf(e.which) === -1;

        if (isLetterSearchable) {

          filterQueryString += letter;

          const $matchedMaterialOption = this.$materialOptionsList.find('li').filter((index, element) => $(element).text().toLowerCase().includes(filterQueryString)).first();

          if (!this.isMultiple) {

            this.$materialOptionsList.find('li').removeClass('active');
          }

          $matchedMaterialOption.addClass('active');
          this._selectSingleOption($matchedMaterialOption);
        }
      }
    }

    _onSearchInputKeyup(e) {

      const $this = $(e.target);

      const isTab = e.which === this.keyCodes.tab;
      const isEsc = e.which === this.keyCodes.esc;
      const isEnter = e.which === this.keyCodes.enter;
      const isEnterWithShift = isEnter && e.shiftKey;
      const isArrowUp = e.which === this.keyCodes.arrowUp;
      const isArrowDown = e.which === this.keyCodes.arrowDown;

      if (isArrowDown || isTab || isEsc || isArrowUp) {
        
        this.$materialSelect.focus();
        this._handleArrowDownKey();
        return
      } 

      const $ul = $this.closest('ul');
      const searchValue = $this.val();
      const $options = $ul.find('li span.filtrable');

      let isOptionInList = false;

      $options.each(function () {

        const $option = $(this);
        if (typeof this.outerHTML === 'string') {

          const liValue = this.textContent.toLowerCase();

          if (liValue.includes(searchValue.toLowerCase())) {

            $option.show().parent().show();
          } else {
            $option.hide().parent().hide();
          }
          
          if (liValue.trim() === searchValue.toLowerCase()) {
            isOptionInList = true;
          }
        }
      });
      
      if (isEnter) {
        if (this.isEditable && !isOptionInList) {
          this.addNewOption();
          return;
        }
        if (isEnterWithShift) {
          this._handleEnterWithShiftKey($this);
        }
        this.$materialSelect.trigger('open');
        return;
      }

      if (searchValue && this.isEditable && !isOptionInList) {
        this.$addOptionBtn.show();
      } else {
        this.$addOptionBtn.hide();
      }

      this._updateToggleAllOption();
    }

    _isToggleAllPresent() {

      return this.$materialOptionsList.find(this.$toggleAll).length;
    }

    _updateToggleAllOption() {

      const $allOptionsButToggleAll = this.$materialOptionsList.find('li').not('.select-toggle-all, .disabled, :hidden').find('[type=checkbox]');
      const $checkedOptionsButToggleAll = $allOptionsButToggleAll.filter(':checked');
      const isToggleAllChecked = this.$toggleAll.find('[type=checkbox]').is(':checked');

      if ($checkedOptionsButToggleAll.length === $allOptionsButToggleAll.length && !isToggleAllChecked) {

        this.$toggleAll.find('[type=checkbox]').prop('checked', true);
      } else if ($checkedOptionsButToggleAll.length < $allOptionsButToggleAll.length && isToggleAllChecked) {

        this.$toggleAll.find('[type=checkbox]').prop('checked', false);
      }
    }

    _toggleSelectedValue(optionIndex) {

      const selectedValueIndex = this.valuesSelected.indexOf(optionIndex);
      const isSelected = selectedValueIndex !== -1;

      if (!isSelected) {

        this.valuesSelected.push(optionIndex);
      } else {

        this.valuesSelected.splice(selectedValueIndex, 1);
      }

      this.$materialOptionsList.find('li:not(.optgroup):not(.select-toggle-all)').eq(optionIndex).toggleClass('active');
      this.$nativeSelect.find('option').eq(optionIndex).prop('selected', !isSelected);

      this._setValueToMaterialSelect();

      return !isSelected;
    }

    _selectSingleOption(newOption) {

      this.$materialOptionsList.find('li.selected').removeClass('selected');

      this._selectOption(newOption);
    }

    _selectOption(newOption) {

      const option = $(newOption);
      option.addClass('selected');
    }

    _setValueToMaterialSelect() {

      let value = '';
      let optionsSelected = this.optionsSelectedLabel;
      const itemsCount = this.valuesSelected.length;

      if (this.options.language.active && this.$toggleAll) {

        if (this.options.language.pl) {

          optionsSelected = this.options.language.pl.optionsSelected ? this.options.language.pl.optionsSelected : this.defaults.language.pl.optionsSelected;
        } else if (this.options.language.fr) {

          optionsSelected = this.options.language.fr.optionsSelected ? this.options.language.fr.optionsSelected : this.defaults.language.fr.optionsSelected;
        } else if (this.options.language.ge) {

          optionsSelected = this.options.language.ge.optionsSelected ? this.options.language.ge.optionsSelected : this.defaults.language.ge.optionsSelected;
        } else if (this.options.language.ar) {

          optionsSelected = this.options.language.ar.optionsSelected ? this.options.language.ar.optionsSelected : this.defaults.language.ar.optionsSelected;
        } else if (this.options.language.in) {

          optionsSelected = this.options.language.in.optionsSelected ? this.options.language.in.optionsSelected : this.defaults.language.in.optionsSelected;
        }
      }

      this.valuesSelected.map(el => value += `, ${this.$nativeSelect.find('option').eq(el).text().replace(/  +/g, ' ').trim()}`);     

      itemsCount >= 5 ? value = `${itemsCount} ${optionsSelected}` : value = value.substring(2);

      value.length === 0 && this.mainLabel.length === 0 ? value = this.$nativeSelect.find('option:disabled').eq(0).text() : null;

      value.length > 0 && !this.options.BSinputText ? this.mainLabel.addClass('active ') : this.mainLabel.removeClass('active');

      this.options.BSinputText ? this.mainLabel.css('top', '-7px') : null;

      this.$nativeSelect.siblings(`${this.options.BSinputText ? 'input.multi-bs-select' : 'input.select-dropdown'}`).val(value);
    }

    _randomUUID() {

      let d = new Date().getTime();

      return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, c => {

        const r = (d + Math.random() * 16) % 16 | 0;
        d = Math.floor(d / 16);
        return (c === 'x' ? r : r & 0x3 | 0x8).toString(16);
      });
    }
  }

  $.fn.materialSelect = function (callback) {

    $(this).not('.browser-default').not('.custom-select').each(function () {

      const materialSelect = new MaterialSelect($(this), callback);
      materialSelect.init();
    });
  };

  $.fn.material_select = $.fn.materialSelect;

  (function (originalVal) {

    $.fn.val = function (value) {

      if (!arguments.length) {

        return originalVal.call(this);
      }

      if (this.data('stop-refresh') !== true && this.hasClass('mdb-select') && this.hasClass('initialized')) {

        MaterialSelect.clearMutationObservers();

        this.materialSelect({
          destroy: true
        });

        const ret = originalVal.call(this, value);
        this.materialSelect();

        return ret;
      }

      return originalVal.call(this, value);
    };
  }($.fn.val));
}(jQuery));

$('select').siblings('input.select-dropdown', 'input.multi-bs-select').on('mousedown', e => {
  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    if (e.clientX >= e.target.clientWidth || e.clientY >= e.target.clientHeight) {
      e.preventDefault();
    }
  }
});

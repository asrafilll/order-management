@props(['name'])

<div>
    <div
        class="modal fade"
        id="filter-{{ $name }}"
        tabindex="-1"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Filter') }}</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ui-front">
                    <div
                        class="form-group"
                        id="common-date-{{ $name }}-module"
                    >
                        <label>{{ __('Date') }}</label>
                        <div class="btn-group w-100">
                            <button
                                type="button"
                                class="btn btn-default btn-common-date"
                                data-value="week"
                            >{{ __('This Week') }}</button>
                            <button
                                type="button"
                                class="btn btn-default btn-common-date"
                                data-value="month"
                            >
                                {{ __('This Month') }}
                            </button>
                            <button
                                type="button"
                                class="btn btn-default btn-common-date"
                                data-value="year"
                            >
                                {{ __('This Year') }}
                            </button>
                        </div>
                    </div>
                    <script>
                        const CommonDate{{ $name }} = (function() {
                            const $el = $('#common-date-{{ $name }}-module');
                            const $btn = $el.find('.btn-common-date');

                            $btn.on('click', handleClick);

                            function handleClick() {
                                const value = $(this).data('value');
                                const currentDate = new Date();
                                let startDate = null;
                                let endDate = null;

                                switch (value) {
                                    case 'week': {
                                        const first = currentDate.getDate() - currentDate.getDay() + 1;
                                        const last = first + 6;
                                        startDate = new Date(currentDate.setDate(first));
                                        endDate = new Date(currentDate.setDate(last));
                                        break;
                                    }
                                    case 'month':
                                        startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                                        endDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
                                        break;
                                    case 'year':
                                        startDate = new Date(currentDate.getFullYear(), 0, 1);
                                        endDate = new Date(currentDate.getFullYear() + 1, 0, 0);
                                        break;
                                }

                                StartDate{{ $name }}.setValue(formatDate(startDate));
                                EndDate{{ $name }}.setValue(formatDate(endDate));
                            }

                            function formatDate(date) {
                                return [
                                    date.getFullYear(),
                                    String(date.getMonth() + 1).padStart(2, '0'),
                                    String(date.getDate()).padStart(2, '0'),
                                ].join('-');
                            }
                        })();
                    </script>
                    <div class="row">
                        <div
                            class="form-group col-lg"
                            id="start-date-{{ $name }}-module"
                        >
                            <label for="start_date">{{ __('Start Date') }}</label>
                            <input
                                type="text"
                                name="start_date"
                                id="start_date-{{ $name }}"
                                class="form-control"
                            />
                        </div>
                        <script>
                            const StartDate{{ $name }} = (function() {
                                const $el = $('#start-date-{{ $name }}-module');
                                const $input = $el.find('#start_date-{{ $name }}');

                                init()

                                function init() {
                                    $input.datetimepicker({
                                        format: 'Y-m-d',
                                        timepicker: false,
                                        onShow: function(ctx) {
                                            this.setOptions({
                                                maxDate: EndDate{{ $name }}.getValue() || false,
                                            });
                                        },
                                    });
                                }

                                function getValue() {
                                    return $input.val() || null;
                                }

                                function setValue(value) {
                                    $input.val(value);
                                }

                                return {
                                    getValue: getValue,
                                    setValue: setValue,
                                };
                            })();
                        </script>
                        <div
                            class="form-group col-lg"
                            id="end-date-{{ $name }}-module"
                        >
                            <label for="end_date">{{ __('End Date') }}</label>
                            <input
                                type="text"
                                name="end_date"
                                id="end_date-{{ $name }}"
                                class="form-control"
                            />
                        </div>
                        <script>
                            const EndDate{{ $name }} = (function() {
                                const $el = $('#end-date-{{ $name }}-module');
                                const $input = $el.find('#end_date-{{ $name }}');

                                init()

                                function init() {
                                    $input.datetimepicker({
                                        format: 'Y-m-d',
                                        timepicker: false,
                                        onShow: function(ctx) {
                                            this.setOptions({
                                                minDate: StartDate{{ $name }}.getValue() || false,
                                            });
                                        },
                                    });
                                }

                                function getValue() {
                                    return $input.val() || null;
                                }

                                function setValue(value) {
                                    $input.val(value);
                                }

                                return {
                                    getValue: getValue,
                                    setValue: setValue,
                                };
                            })();
                        </script>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                    >{{ __('Cancel') }}</button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        id="btn-submit-{{ $name }}"
                    >{{ __('Apply') }}</button>
                    <script>
                        $('#btn-submit-{{ $name }}').on('click', function() {
                            const params = new URLSearchParams();
                            const startDate = StartDate{{ $name }}.getValue();
                            if (startDate) params.set('start_date', startDate);

                            const endDate = EndDate{{ $name }}.getValue();
                            if (endDate) params.set('end_date', endDate);

                            {{ $name }}Module.setParams(params.toString());
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

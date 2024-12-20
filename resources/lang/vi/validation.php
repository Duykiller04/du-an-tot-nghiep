<?php

return [
    'accepted' => 'Trường :attribute phải được chấp nhận.',
    'active_url' => 'Trường :attribute không phải là một URL hợp lệ.',
    'after' => 'Trường :attribute phải là một ngày sau :date.',
    'after_or_equal' => 'Trường :attribute phải là một ngày sau hoặc bằng :date.',
    'alpha' => 'Trường :attribute chỉ có thể chứa các chữ cái.',
    'alpha_dash' => 'Trường :attribute chỉ có thể chứa chữ cái, số, dấu gạch ngang và gạch dưới.',
    'alpha_num' => 'Trường :attribute chỉ có thể chứa chữ cái và số.',
    'array' => 'Trường :attribute phải là một mảng.',
    'before' => 'Trường :attribute phải là một ngày trước :date.',
    'before_or_equal' => 'Trường :attribute phải là một ngày trước hoặc bằng :date.',
    'between' => [
        'numeric' => 'Trường :attribute phải nằm trong khoảng :min - :max.',
        'file' => 'Trường :attribute phải có dung lượng trong khoảng :min - :max kilobytes.',
        'string' => 'Trường :attribute phải có độ dài từ :min đến :max ký tự.',
        'array' => 'Trường :attribute phải chứa từ :min đến :max phần tử.',
    ],
    'boolean' => 'Trường :attribute phải là true hoặc false.',
    'confirmed' => 'Trường :attribute không khớp.',
    'date' => 'Trường :attribute không phải là ngày hợp lệ.',
    'date_equals' => 'Trường :attribute phải là một ngày bằng :date.',
    'date_format' => 'Trường :attribute không khớp với định dạng :format.',
    'different' => 'Trường :attribute và :other phải khác nhau.',
    'digits' => 'Trường :attribute phải có :digits chữ số.',
    'digits_between' => 'Trường :attribute phải có từ :min đến :max chữ số.',
    'dimensions' => 'Trường :attribute có kích thước hình ảnh không hợp lệ.',
    'distinct' => 'Trường :attribute có giá trị trùng lặp.',
    'email' => 'Trường :attribute phải là một địa chỉ email hợp lệ.',
    'ends_with' => 'Trường :attribute phải kết thúc bằng một trong các giá trị sau: :values.',
    'exists' => 'Giá trị được chọn cho :attribute không hợp lệ.',
    'file' => 'Trường :attribute phải là một tệp.',
    'filled' => 'Trường :attribute phải có giá trị.',
    'gt' => [
        'numeric' => 'Trường :attribute phải lớn hơn :value.',
        'file' => 'Trường :attribute phải lớn hơn :value kilobytes.',
        'string' => 'Trường :attribute phải lớn hơn :value ký tự.',
        'array' => 'Trường :attribute phải có nhiều hơn :value phần tử.',
    ],
    'gte' => [
        'numeric' => 'Trường :attribute phải lớn hơn hoặc bằng :value.',
        'file' => 'Trường :attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string' => 'Trường :attribute phải lớn hơn hoặc bằng :value ký tự.',
        'array' => 'Trường :attribute phải có :value phần tử trở lên.',
    ],
    'lt' => [
        'numeric' => 'Trường :attribute phải nhỏ hơn :value.',
        'file' => 'Trường :attribute phải nhỏ hơn :value kilobytes.',
        'string' => 'Trường :attribute phải nhỏ hơn :value ký tự.',
        'array' => 'Trường :attribute phải có ít hơn :value phần tử.',
    ],
    'lte' => [
        'numeric' => 'Trường :attribute phải nhỏ hơn hoặc bằng :value.',
        'file' => 'Trường :attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'string' => 'Trường :attribute phải nhỏ hơn hoặc bằng :value ký tự.',
        'array' => 'Trường :attribute phải có :value phần tử trở xuống.',
    ],
    'max' => [
        'numeric' => 'Trường :attribute phải nhỏ hơn :max.',
        'file' => 'Trường :attribute phải nhỏ hơn :max kilobytes.',
        'string' => 'Trường :attribute phải nhỏ hơn :max ký tự.',
        'array' => 'Trường :attribute phải có ít hơn :max phần tử.',
    ],
    'mimes' => 'Trường :attribute phải là một tệp có kiểu :values.',
    'mimetypes' => 'Trường :attribute phải là một tệp có kiểu :values.',
    'min' => [
        'numeric' => 'Trường :attribute phải lớn hơn :min.',
        'file' => 'Trường :attribute phải lớn hơn :min kilobytes.',
        'string' => 'Trường :attribute phải lớn hơn :min ký tự.',
        'array' => 'Trường :attribute phải có ít nhất :min phần tử.',
    ],
    'not_in' => 'Giá trị được chọn cho :attribute không hợp lệ.',
    'not_regex' => 'Trường :attribute không khớp với định dạng :format.',
    'numeric' => 'Trường :attribute phải là một số.',
    'password' => 'Mật khẩu không hợp lệ.',
    'present' => 'Trường :attribute phải có giá trị.',
    'regex' => 'Trường :attribute không khớp với định dạng :format.',
    'required' => 'Trường :attribute là bắt buộc.',
    'required_if' => 'Trường :attribute là bắt buộc khi :other là :value.',
    'required_unless' => 'Trường :attribute là bắt buộc trừ khi :other là :value.',
    'required_with' => 'Trường :attribute là bắt buộc khi :values có giá trị.',
    'required_with_all' => 'Trường :attribute là bắt buộc khi :values có giá trị.',
    'required_without' => 'Trường :attribute là bắt buộc khi :values không có giá trị.',
    'required_without_all' => 'Trường :attribute là bắt buộc khi :values không có giá trị.',
    'same' => 'Trường :attribute và :other phải giống nhau.',
    'size' => [
        'numeric' => 'Trường :attribute phải có kích thước :size.',
        'file' => 'Trường :attribute phải có kích thước :size kilobytes.',
        'string' => 'Trường :attribute phải có kích thước :size ký tự.',
        'array' => 'Trường :attribute phải có :size phần tử.',
    ],
    'string' => 'Trường :attribute phải là một chuỗi.',
    'timezone' => 'Trường :attribute phải là một khu vực hợp lệ.',
    'unique' => 'Trường :attribute đã tồn tại.',
    'uploaded' => 'Trường :attribute không được upload.',
    'url' => 'Trường :attribute phải là một URL hợp lệ.',
    'uuid' => 'Trường :attribute phải là một UUID hợp lệ.',
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    'attributes' => [
        'email' => 'địa chỉ email',
        'password' => 'mật khẩu',
        'name' => 'tên',
        'phone' => 'số điện thoại',
        'address' => 'địa chỉ',
    ],
];

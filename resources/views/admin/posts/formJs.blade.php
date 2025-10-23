{{--<Script>--}}
$scope.loading = {};
$scope.getFileName = getFileName;

$(document).on('change', '[id^="gallery-chooser-"]', function(e) {
    let id = $(this).attr('id');
    let parts = id.split('-');
    let blockIndex = parts[parts.length - 1];

    let block = $scope.form.blocks[blockIndex];

    Array.from(this.files).forEach(file => {
        let newGallery = block.addGallery({});
        $timeout(() => {
            let inputElem = document.getElementById(newGallery.image.element_id);
            if (inputElem) {
                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                inputElem.files = dataTransfer.files;
                newGallery.image.path = URL.createObjectURL(file);
                $(inputElem).trigger('change');
            }
        }, 50);
        if(!$scope.$$phase) {
            $scope.$apply();
        }
    });
});


// Giữ nguyên mảng gốc
var items = ($scope.form.all_categories || []);

// Tính số con theo parent_id
var childCount = {};
items.forEach(function (c) {
if (c.parent_id && c.parent_id !== 0) {
childCount[c.parent_id] = (childCount[c.parent_id] || 0) + 1;
}
});

// Gắn cờ cho từng item
items.forEach(function (it) {
it._child_count = childCount[it.id] || 0;
// Cha có con => disable; còn lại chọn bình thường
it._disabled = (it.parent_id === 0 && it._child_count > 0);
// (tuỳ chọn) đặt nhãn hiển thị
it._label_suffix = (it.parent_id === 0)
? (it._child_count > 0 ? '' : '')
: '';
});

$scope.form.all_categories_marked = items;


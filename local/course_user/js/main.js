require(["jquery"], function ($) {
  const searchSubmitFn = function (e) {
    e.preventDefault();
    e.stopPropagation();

    courseCatalogueRouteParams.search =
      $("#input-catalogue-search").val() || null;
    courseCatalogueRouteParams.page = 1;
    updateRoute();
  };

  $("#button-catalogue-search").on("click", searchSubmitFn);
  $("#form-catalogue-search").on("submit", searchSubmitFn);

  $(".form_text_input").keypress(function (e) {
    if (e.which == 10 || e.which == 13) {
      courseCatalogueRouteParams.page = 1;
      if ($(this).attr("type") == "text") {
        courseCatalogueRouteParams[$(this).attr("name")] = $(this).val();
        null;
        updateRoute();
        return;
      }
    }
  });

  const tagSearchSubmitFn = function (e) {
    e.preventDefault();
    e.stopPropagation();

    courseCatalogueRouteParams.tag = $("#input-tag-search").val() || null;
    courseCatalogueRouteParams.page = 1;
    updateRoute();
  };

  $("#button-tag-search").on("click", tagSearchSubmitFn);
  $("#form-tag-search").on("submit", tagSearchSubmitFn);

  $(".input-catalogue-filter").on("change", function (e) {
    courseCatalogueRouteParams.page = 1;

    if ($(this).attr("type") == "radio") {
      courseCatalogueRouteParams[$(this).attr("name")] = $(this).is(":checked")
        ? $(this).val()
        : null;
      updateRoute();
      return;
    }

    // now for checkbox

    // remove [] from name
    const name = $(this).attr("name").replace("[]", "");

    if (
      courseCatalogueRouteParams[name] == null ||
      !courseCatalogueRouteParams[name]
    ) {
      courseCatalogueRouteParams[name] = [];
    }

    if ($(this).is(":checked")) {
      courseCatalogueRouteParams[name].push($(this).val());
    } else {
      // find index of value and remove it
      const index = courseCatalogueRouteParams[name].indexOf($(this).val());

      if (index > -1) {
        courseCatalogueRouteParams[name].splice(index, 1);
      }
    }

    updateRoute();
  });

  function updateRoute() {
    // remove empty params
    for (let key in courseCatalogueRouteParams) {
      if (courseCatalogueRouteParams[key] === null) {
        delete courseCatalogueRouteParams[key];
      }
    }

    window.location.href = `?${$.param(courseCatalogueRouteParams)}`;
  }

  let selectedUsers = [];

  const selectUserUpdated = function () {
    setTimeout(() => {
      // remove duplicates
      selectedUsers = [...new Set(selectedUsers)];

      // update badge
      $(".selected-users-count").html(selectedUsers.length);

      if (selectedUsers.length > 0) {
        $(".helper-buttons .conditional-btn").removeClass("disabled");
      } else {
        $(".helper-buttons .conditional-btn").addClass("disabled");
      }

      if (selectedUsers.length === totalVisibleUsers) {
        $(".select-all-checkbox").prop("checked", true);
        $(".helper-buttons #select-all").addClass("disabled");
      } else {
        $(".select-all-checkbox").prop("checked", false);
        $(".helper-buttons #select-all").removeClass("disabled");
      }
    });
  };

  $(".helper-buttons #select-all").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();

    $(".selectusercheckbox").prop("checked", true).change();
  });

  $(".helper-buttons #unselect-all").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();

    $(".selectusercheckbox").prop("checked", false).change();
  });

  $(".select-all-checkbox").on("change", function (e) {
    if ($(this).is(":checked")) {
      $(".selectusercheckbox").prop("checked", true).change();
    } else {
      $(".selectusercheckbox").prop("checked", false).change();
    }
  });

  $(".selectusercheckbox").on("change", function (e) {
    e.preventDefault();
    e.stopPropagation();

    if ($(this).is(":checked")) {
      selectedUsers.push($(this).val());
    } else {
      if (selectedUsers.indexOf($(this).val()) > -1) {
        selectedUsers.splice(selectedUsers.indexOf($(this).val()), 1);
      }
    }

    selectUserUpdated();
  });
  const projectName = "Bluelms";
  const modalBaseURL = window.location.origin + "/" + projectName + "/local/course_user/";
  const modal = $("#userActionModal");
  console.log(window.location.origin);
  const openModal = function (url, title = null) {
    if (title) {
      modal.find(".modal-title").html(title);
    } else {
      modal.find(".modal-title").html("Selected users");
    }

    modal.modal("show");

    $.ajax({
      url: url,
      beforeSend: function () {
        modal
          .find(".modal-body")
          .html(
            '<div class="text-center py-4 px-1"><div class="spinner-border text-primary" role="status"></div></div>'
          );
      },
      success: function (data) {
        setTimeout(() => {
          modal.find(".modal-body").html(data);
        }, 1000);
      },
      error: function () {
        modal
          .find(".modal-body")
          .html(
            '<div class="alert alert-danger mt-4">Error loading content</div>'
          );
      },
    });
  };

  // #enrol-to-course
  $(".helper-buttons #enrol-to-course").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (selectedUsers.length <= 0) {
      alert("No users selected");
      return;
    }

    openModal(
      modalBaseURL +
        "enrolusers.php?element=enroll&assigntype=user&elementList=" +
        selectedUsers.join(","),
      "Enrol users to courses"
    );
  });

  // #add-to-cohort
  $(".helper-buttons #add-to-cohort").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (selectedUsers.length <= 0) {
      alert("No users selected");
      return;
    }

    openModal(
      modalBaseURL +
        "enrolcohort.php?element=enroll&assigntype=user&elementList=" +
        selectedUsers.join(","),
      "Add users to cohorts"
    );
  });

  // #recommend-Course
  $(".helper-buttons #recommend-course").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (selectedUsers.length <= 0) {
      alert("No users selected");
      return;
    }

    openModal(
      modalBaseURL +
        "recommendcourse.php?element=enroll&assigntype=user&elementList=" +
        selectedUsers.join(","),
      "Recommend courses to users"
    );
  });

  // #delete-users
  $(".helper-buttons #delete-users").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (selectedUsers.length <= 0) {
      alert("No users selected");
      return;
    }

    if (!confirm("Are you sure you want to delete these users?")) {
      return;
    }

    $.ajax({
      url: modalBaseURL + "classes/ajax.php?action=delete",
      type: "POST",
      data: {
        userid: selectedUsers,
      },
      success: function (data) {
        alert("Users deleted successfully");
        window.location.reload();
      },
    });
  });

  $(".delete-user").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();

    if ($(this).hasClass("hidethis")) {
      alert("Permission denied.");
      return false;
    }

    if (confirm("Are you sure want to delete this user?")) {
      $.ajax({
        url: modalBaseURL + "classes/ajax.php",
        type: "POST",
        data: {
          action: "delete",
          userid: $(this).data("id"),
        },
        success: function (data) {
          alert(data);
          location.reload();
        },
      });
    }
  });
});

function refreshPage() {
  location.reload();
}

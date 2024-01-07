const express = require("express");
const app = express();
const cors = require("cors");
const puppeteer = require("puppeteer");
const bodyParser = require("body-parser");

app.timeout = 60000;

app.use(express.json({ limit: "10mb" }));
app.use(cors());
app.use(bodyParser.json({ limit: "20mb" }));
app.use(bodyParser.urlencoded({ limit: "20mb", extended: true }));
app.use((req, res, next) => {
  const contentLength = parseInt(req.headers["content-length"], 10) || 0;
  console.log("Request body size:", contentLength);
  next();
});

// Your other routes and middleware can go here...

app.post("/generate-pdf", async (req, res) => {
  const { tempDiv } = req.body;
  // console.log(tempDiv);

  const browser = await puppeteer.launch();
  const page = await browser.newPage();

  // Generate the PDF from the HTML content
  await page.setContent(tempDiv);
  const pdfBuffer = await page.pdf({
    format: "A4",
    printBackground: true, // Include background colors
  });
  await browser.close();

  // Send the PDF as a response
  res.setHeader("Content-Type", "application/pdf");
  res.setHeader("Content-Disposition", "attachment; filename=generated.pdf");
  res.send(pdfBuffer);
});

const port = 3000;
app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});

$(document).ready(function () {
  $(".blk-widget-inner a").click(function () {
    var t = $(this).data("grp");
    $.ajax({
      url: "<?php echo $baseurl;?>actajax",
      type: "POST",
      data: { assign_grp: t },
      success: function (t) {},
    });
  });
}),
  $(document).ready(function () {
    $(".acpt-grp").on("click", function (t) {
      t.preventDefault();
      t = $(this).data("id");
      $("#subtopic").val(t);
    });
  }),
  $(document).ready(function () {
    $(".blk-widget-inner a").click(function () {
      $(this).data("id"), $(this).next(".tag").hide();
    });
  }),
  $(document).ready(function () {
    $(".fastest-topic").click(function () {
      var t = $(this).data("topic");
      $.ajax({
        url: "<?php echo $baseurl;?>actajax",
        type: "POST",
        data: { asgn_topic: t },
        success: function (t) {
          location.reload();
        },
      });
    });
  });

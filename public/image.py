import os

image_paths = [
    "public/uploads/1/cropped-logo-blue2.png",
    "public/uploads/10/yeast-infection-teaser.jpg",
    "public/uploads/11/Main-asthma.jpg",
    "public/uploads/12/heart-diagram.jpg",
    "public/uploads/13/highbloodpressure.jpeg",
    "public/uploads/14/6476391b7a7452eb45fe4e34_iStock-871475752.jpg",
    "public/uploads/15/diabetes-symptoms-and-treatment.jpg",
    "public/uploads/16/17665-hashimotos-disease.jpg",
    "public/uploads/17/woman-kissing-baby.jpg",
    "public/uploads/18/shutterstock_1479227858-1024x942.jpg",
    "public/uploads/19/63eda1f71cd7f3c98f23bc7f_621957d5758d7468649eef97_ed.jpeg",
    "public/uploads/20/how-to-use-regular-birth-control-as-emergency-contraception-1440x810.jpg",
    "public/uploads/21/what-is-eczema-02-hand-eczema-722x406.jpg",
    "public/uploads/22/athletes-foot.png",
    "public/uploads/23/cellulitis-leg.jpg",
    "public/uploads/24/sept-10-thegem-blog-default.jpeg",
    "public/uploads/25/Depression_APStock72622943-645x645.jpg",
    "public/uploads/26/grief-1000px.jpg",
    "public/uploads/27/agency-young-adult-profession-stressed-black-1.jpg",
    "public/uploads/28/1_J5VYmz9cTpaA0-mKu8CnAQ.jpg",
    "public/uploads/29/blog-postpartum-depression.jpg",
    "public/uploads/3/favico-32.png",
    "public/uploads/30/PTSD.jpg",
    "public/uploads/31/Dec282020_RMG_BlogImage-pqapfqksvj6yjuxho7tr5lfy7gh8c7mafxij4b4420.png",
    "public/uploads/32/download.png",
    "public/uploads/33/bad-to-hold-poop-work-1508257886.jpg",
    "public/uploads/34/man-wearing-black-sportswear-royalty-free-image-991203232-1545662786.jpg",
    "public/uploads/35/Diet-and-Nutrition.jpg",
    "public/uploads/36/risk-of-poor-medication-management-scaled.jpg",
    "public/uploads/37/man-wearing-black-sportswear-royalty-free-image-991203232-1545662786.jpg",
    "public/uploads/5/gettyimages-157311205-allergies-tomml-1518556351.jpg",
    "public/uploads/6/S_0917_acne_M1080444.max-600x600.jpg",
    "public/uploads/7/CoughCold350x294.jpg",
    "public/uploads/9/Public_Diseases_Hair-Loss_Symptoms-hair-brush.jpg"
]

for image_path in image_paths:
    if os.path.exists(image_path):
        os.remove(image_path)
        print(f"Deleted: {image_path}")
    else:
        print(f"File not found: {image_path}")

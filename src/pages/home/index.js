import Blog from "../../components/blog/blog";
import Contact from "../../components/contact/contact";
import Footer from "../../components/footer/footer";
import ImageText from "../../components/imageText/imageText";
import Navbar from "../../components/navbar/Navbar";
import ServicesCard from "../../components/servicesCard/card";
import ImagesSlider from "../../components/slider/imagesSlider";
import { imagesdata } from "../../data/imagesdata";
import { servicesData } from "../../data/servicesData";
import Faq from "../../components/faq/faq";
import { useEffect } from "react";
import { useLocation } from "react-router-dom";

function Home() {
  const hashs = ["services", "contact", "about-us"];

  const location = useLocation();
  useEffect(() => {
    const findHash = hashs.find((hash) => location.hash.includes(hash));
    //console.log(findHash);

    if (findHash) {
      //console.log(location.hash);
      //console.log(element);
      // element.scrollTop = element.offsetTop;

      setTimeout(() => {
        const element = document.getElementById(findHash);
        //console.log(element);
        const distance =
          window.pageYOffset + element.getBoundingClientRect().top;
        window.scrollTo({ top: distance, behavior: "smooth" });
      }, 1000);
    }
    //console.log(location);
  });
  return (
    <>
      <ImagesSlider imagesdata={imagesdata} />

      <ServicesCard servicesData={servicesData} />
      <ImageText />
      <Blog />
      <Contact />
    </>
  );
}

export default Home;

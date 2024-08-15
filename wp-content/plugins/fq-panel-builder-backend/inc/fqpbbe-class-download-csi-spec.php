<?php
/**
 *
 */

use PhpOffice\PhpWord\PhpWord;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'FQPBBE_Download_CSI_Spec' ) ) {

    class FQPBBE_Download_CSI_Spec {

        protected $phpWord;
        protected $section;
        protected $basicFont = ['name' => 'Arial', 'size' => 12];

        public function download( WP_REST_Request $request )
        {
            $this->phpWord = new PhpWord();
            $this->section = $this->phpWord->addSection();

            $this->phpWord->addNumberingStyle(
                'multilevel',
                array(
                    'type' => 'multilevel',
                    'levels' => array(
                        array('format' => 'decimal', 'text' => '%1', 'left' => 360, 'hanging' => 360, 'tabPos' => 360),
                        array('format' => 'decimal', 'text' => '%1.%1', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
                        array('format' => 'upperLetter', 'text' => '%3.', 'left' => 1080, 'hanging' => 360, 'tabPos' => 1080),
                        array('format' => 'decimal', 'text' => '%4.', 'left' => 1080 + 360, 'hanging' => 360, 'tabPos' => 1080 + 360),
                        array('format' => 'lowerLetter', 'text' => '%5.', 'left' => 360 * 5, 'hanging' => 360, 'tabPos' => 360 * 5),
                        array('format' => 'decimal', 'text' => '%6.', 'left' => 360 * 6, 'hanging' => 360, 'tabPos' => 360 * 6),
                    )
                )
            );

            $this->addContent();

            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->phpWord, 'Word2007');
            return $objWriter->save('php://output');
        }

        public function addContent()
        {
            $this->addBasicText('SECTION 06 42 00', true);
            $this->addBasicText('INTERIOR HARDWOOD PANELS', true);
            $this->addBasicText('', true);
            $this->addBasicText('Copyright 2018 - 2020 ARCAT, Inc. - All rights reserved', true);

            $this->addListItem('GENERAL');
            $this->addListItem('SECTION INCLUDES', 1);
            $this->addListItem('Hardwood veneered panels for interior applications.', 2);

            $this->addListItem('RELATED SECTIONS', 1);
            $this->addListItem('Section 06 41 14 - Plastic Laminate Faced Architectural Cabinets.', 2);

            $this->addListItem('REFERENCES', 1);
            $this->addListItem('ASTM E 84 - Standard Test Method for Surface Burning Characteristics of Building Materials.', 2);

            $this->addListItem('DEFINITIONS', 1);
            $this->addListItem('Hardwood Plywood Terms:', 2);
            $this->addListItems([
                    "Backs: Some plywood panels are specified with different grades of veneer on each side. The lower grade side of a plywood panel is called the Back.",
                    "Bark Pocket: An area on a sheet of veneer where a tree branch grew, thus trapping a small amount of bark, usually around a knot. Core: Inner plies of a panel product, usually composed of veneer. Alternatively, cores can be made of particleboard, MDF or lumber.",
                    "Crossbar: A defect in panel manufacturing where a piece of veneer runs perpendicular to the length of the board.",
                    "Crossbanding: Crossbanding refers to the orientation of successive layers of veneer layup by placing them perpendicular to the face and back of a plywood panel.",
                    "Defects: Any number of imperfections in a panel product's appearance or surface, including splits, stains, voids, holes, open knots, bark pockets and other issues.",
                    "Delamination: Panel separation caused by adhesive failure.",
                    "Face: Some plywood panels are specified with different grades of veneer on each side. The higher grade side of a plywood panel is called the Front.",
                    "Flitch: The complete bundle of thin sheets of veneer after cutting, laid together in sequence as they were sliced or sawn.",
                    "Grain: The distinctive, natural pattern, size and direction of the fibers in sliced or sawn wood.",
                    "Gum Spots: Sap or resin left on wood from veneer sawing or slicing. Gum spots can usually be removed by sanding.",
                    "Half-Round Slicing: When a log is cut tangential to its growth rings, the result is a plain sliced or rotary grain pattern.",
                    "Hardwood: Any species of deciduous tree lumber or veneer. Coniferous tree lumber is called Softwood. The term Hardwood has no relationship to the density of the wood.",
                    "Heartwood: The oldest part of a log radiating from the center, consisting of mature",
                    "Knot (Pin): Very small knots less than 1/4\" in diameter.",
                    "Knot (Sound): Knots that have not separated from the surrounding fiber during the drying process.",
                    "Knothole: A void in lumber or veneer created when a knot is missing from its original location.",
                    "Lap: Orientation of two pieces of veneer next to one another in the same layer of ply.",
                    "Medium Density Fiberboard (MDF): A wood flour material made from pressure-cooked wood fiber, resin and wax.",
                    "Mineral Streak: A discoloration of hardwood and hardwood veneer.",
                    "Particleboard: A panel or core material manufactured from pressed sawmill shavings, resin and wax.",
                    "Patches: Material placed onto defects in veneers to repair voids and other imperfections.",
                    "Plain Sliced: When a log is cut tangential to the tree's annual growth rings.",
                    "Ply: One layer in a wood panel product. Varying numbers of plies make up a sheet of plywood.",
                    "Plywood, Hardwood: A panel product with a hardwood face veneer. The back veneer is usually hardwood as well. Hardwood plywood may or may not have softwood inner plies.",
                    "Quarter Slicing: A veneer cutting method in which a log is sliced at right angles to the annular growth rings.",
                    "Rift Cut: A veneer cutting method in which a log is cut into quarters and then at a 90-degree angle to the grain direction.",
                    "Rotary Cut: A peeling process whereby a whole log is set in a lathe and turned against a large knife.",
                    "Sapwood: The youngest, newest wood in a lumber or veneer, located between the heartwood and the bark.",
                    "Slip Matched: When veneer is carefully aligned to form a whole sheet with a pleasing grain appearance.",
                    "Splits: Cracks in the wood fiber running parallel to the grain in veneer, usually from drying.",
                    "Veneer: Peeled or sliced sheets of thin wood used to make the layers of plywood. Wood that has stopped growing. Usually, heartwood is darker than sapwood.",
                    "Knot: The place on lumber or veneer where a branch once emerged from the trunk of the tree.",
                    "Knot (Open): The condition of a knot that has separated from the fibers surrounding it due to the drying process.",
            ], 3);

            $this->addListItem('SUBMITTALS', 2);
            $this->addListItem('Submit under provisions of Section 01 30 00 - Administrative Requirements.', 3);
            $this->addListItem("Product Data: Manufacturer's data sheets on each product to be used, including:", 3);
            $this->addListItems([
                "Preparation instructions and recommendations.",
                "Storage and handling requirements and recommendations.",
                "Installation methods."
            ], 4);
            $this->addListItem("Selection Samples: For each finish product specified, two complete sets of color chips representing manufacturer's full range of available colors and patterns.", 3);
            $this->addListItem("Verification Samples: For each finish product specified, two samples, minimum size 6 inches (150 mm) square representing actual product, color, and patterns.", 3);

            $this->addListItem('QUALITY ASSURANCE', 2);
            $this->addListItem('Manufacturer Qualifications: Minimum 5 year experience manufacturing similar products.', 3);
            $this->addListItem('Installer Qualifications: Minimum 2 year experience installing similar products.', 3);
            $this->addListItem('Mock-Up: Provide a mock-up for evaluation of surface preparation techniques and application workmanship.', 3);
            $this->addListItems([
                "Finish areas designated by Architect.",
                "Do not proceed with remaining work until workmanship is approved by Architect.",
                "Refinish mock-up area as required to produce acceptable work."
            ], 4);

            $this->addListItem("PRE-INSTALLATION MEETINGS", 2);
            $this->addListItem("Convene minimum two weeks prior to starting work of this section.", 3);

            $this->addListItem("DELIVERY, STORAGE, AND HANDLING", 2);
            $this->addListItem("Deliver and store products in manufacturer's unopened packaging bearing the brand name and manufacturer's identification until ready for installation.", 3);
            $this->addListItem("Handling: Handle materials to avoid damage.", 3);

            $this->addListItem("PROJECT CONDITIONS", 2);
            $this->addListItem("Maintain environmental conditions (temperature, humidity, and ventilation) within limits recommended by manufacturer for optimum results. Do not install products under environmental conditions outside manufacturer's recommended limits.", 3);

            $this->addListItem("SEQUENCING", 2);
            $this->addListItem("Ensure that products of this section are supplied to affected trades in time to prevent interruption of construction progress.", 3);

            $this->addListItem("PRODUCTS", 1);
            $this->addListItem("MANUFACTURERS", 2);

            $this->addListItem("Acceptable Manufacturer: Acceptable Manufacturer: States Industries LLC, which is located at: P. O. Box 41150; Eugene, OR 97404; ASD Toll Free Tel: 800-626-1981; Tel: 541-688-7871; Fax: 541-689-8051; Email:request info; Web:https://www.statesind.com", 3);
            $this->addListItem("Substitutions: Not permitted.", 3);
            $this->addListItem("Requests for substitutions will be considered in accordance with provisions of Section 01 60 00 - Product Requirements.");

            $this->addListItem("HARDWOOD PANELING - GENERAL", 2);
            $this->addListItem("Panels shall comply with California Air Resources Board (CARB) 93120.", 3);
            $this->addListItem("Hardwood Panel Face Veneers:", 3);
            $this->addListItems([
                "Veneers shall comply with cutting, matching and grading as scheduled or required.",
                "Panels shall be factory finished with 100% solids UV-cured acrylate systems of epoxy, polyester and urethanes to comply with exposure and application."
            ], 4);

            $this->addListItem("Veneer Cores:", 3);
            $this->addListItems([
                "Cores shall be Class A fire rated where required or scheduled.",
                "Provide Forest Stewardship Council certified construction.",
                "Cores shall be hardwood veneer innerplies as scheduled constructed using formaldehyde-free soy adhesive"
            ], 4);
            $this->addListItems([
                "Core: ApplePly as manufactured by States Industries.",
                "Cores shall be certified No Added Formaldehyde (NAF).",
                "Adhesive: SoyStrong as manufactured by States Industries."
            ], 5);
            $this->addListItem("Cores shall be composite crossbands with veneer innerplies as scheduled constructed using formaldehyde-free soy adhesive.", 4);
            $this->addListItems([
                "Core: ArmorCore as manufactured by States Industries.",
                "Cores shall be certified No Added Urea Formaldehyde (NAUF).",
                "Adhesive: SoyStrong as manufactured by States Industries.",
            ], 5);
            $this->addListItem("Cores shall be composite crossbands as scheduled constructed using formaldehyde-free soy adhesive.", 4);
            $this->addListItems([
                "Core: Veneer Core as manufactured by States Industries.",
                "Cores shall be certified No Added Urea Formaldehyde (NAUF).",
                "Adhesive: SoyStrong as manufactured by States Industries."
            ], 5);

            $this->addListItem("Composite Cores:", 3);
            $this->addListItem("Cores shall be Class A fire rated where required or scheduled.", 4);
            $this->addListItem("Provide Forest Stewardship Council certified construction.", 5);
            $this->addListItem("Cores shall be particleboard or medium density fiberboard (MDF) with density as scheduled constructed using formaldehyde-free soy adhesive", 4);
            $this->addListItems([
                "Core: Composite Core as manufactured by States Indiustries.",
                "Cores shall be certified No Added Urea Formaldehyde (NAUF).",
                "Adhesive: SoyStrong as manufactured by States Industries.",
            ], 5);
            $this->addListItem("Formaldehyde-Free Soy Adhesive:", 3);
            $this->addListItem("SoyStrong as manufactured by States Industries.", 4);

            $this->addListItem("PANEL CORE PERFORMANCE", 2);
            $this->addListItem("Birch Veneer Core:", 3);
            $this->addListItems([
                "Product: ApplePly as manufactured by States Industries.",
                "Provide Forest Stewardship Council certified construction.",
                "Construction: 1/16 inch (1.6 mm) uniform laminations. Tolerances comply with American National Standards Institute (ANSI/HPVA) grade rules, HP-1-2004.",
                "Performance: 1/4 inch (6 mm) ApplePly."
            ], 4);
            $this->addListItem("Modulus of Rupture (PSI):", 5);
            $this->addListItem("Parallel: 7,477.", 6);
            $this->addListItem("Perpendicular: 5,199.", 6);
            $this->addListItem("Modulus of Elasticity (PSI)", 5);
            $this->addListItem("Parallel: 745,716.", 6);
            $this->addListItem("Perpendicular: 443,927.", 6);
            $this->addListItem("Screw Withdrawal (Lb. Force)", 5);
            $this->addListItem("Perp. to Face: 649", 6);
            $this->addListItem("Perp. to Edge: 516", 6);
            $this->addListItem("Performance: 1/2 inch (13 mm) ApplePly.", 4);
            $this->addListItem("Performance: 1/2 inch (13 mm) ApplePly.", 4);
            $this->addListItem("Modulus of Rupture (PSI):", 5);
            $this->addListItem("Parallel: 8,855.", 6);
            $this->addListItem("Perpendicular: 8,380.", 6);
            $this->addListItem("Modulus of Elasticity (PSI)", 5);
            $this->addListItem("Parallel: 830,436.", 6);
            $this->addListItem("Perpendicular: 910,679.", 6);
            $this->addListItem("Screw Withdrawal (Lb. Force)", 5);
            $this->addListItem("Perp. to Face: 649.", 6);
            $this->addListItem("Perp. to Edge: 516.", 6);
            $this->addListItem("Performance: 3/4 inch (19 mm) ApplePly.", 4);
            $this->addListItem("Modulus of Rupture (PSI):", 5);
            $this->addListItem("Parallel: 8,731.", 6);
            $this->addListItem("Perpendicular: 9,429.", 6);
            $this->addListItem("Modulus of Elasticity (PSI)", 5);
            $this->addListItem("Parallel: 1,026,885.", 6);
            $this->addListItem("Perpendicular: 1,048,433.", 6);
            $this->addListItem("Screw Withdrawal (Lb. Force)", 5);
            $this->addListItem("Perp. to Face: 649.", 6);
            $this->addListItem("Perp. to Edge: 516.", 6);

            $this->addListItem("Composite Core:", 3);
            $this->addListItems([
                "Construction: Cores shall be composite crossbands with veneer innerplies as scheduled constructed using formaldehyde-free soy adhesive.",
                "Product: ArmorCore as manufactured by States Industries.",
                "Construction Tolerance: Core tolerances of +0 - 3/64 inch (0 to 1.2 mm).",
                "Construction Tolerance: Core critical tolerances of +0 - 1/32 inch (0 to 0.79 mm).",
                "Performance:"
            ], 4);
            $this->addListItems([
                "Modulus of Elasticity (PSI): 630,200.",
                "Modulus of Rupture (PSI): 4,922.",
                "Screw Holding, edge: 271.",
                "Screw Holding, face: 324.",
            ], 5);

            $this->addListItem("PREFINISHED PANELS", 2);
            $this->addListItem("Panels shall be factory finished with 100% UV-cured acrylate finish system.", 3);
            $this->addListItem("Thermofused Melamine Backed Panels.", 3);
            $this->addListItems([
                "Product: Veras panels as manufactured by States Industries.",
                "Panels are available from 1/2 inch (13 mm) through 1-1/4 inches (32 mm) with ArmorCore, MDF or Particleboard cores as scheduled.",
                "Fire Rated MDF or Particleboard and FSC Certified constructions are available.",
                "Finish: NOVA finishes as manufactured by States Industries.",
                "Color: Almond.",
                "Color: Black.",
                "Color: Hard Rock Maple.",
                "Color: International White.",
                "Color: Galaxy White.",
                "Color: Natural maple.",
            ], 4);
            $this->addListItem("Cross Grained Hardwood Plywood Panels:", 3);
            $this->addListItems([
                "Product: UPFRONT cross grained panels as manufactured by States Industries.",
                "Finish: Clear NOVA finish as manufactured by States Industries.",
                "Cores include Lauan, Fir veneer, MDF, Particleboard and ArmorCore. Not all cores are available in all thicknesses. Cross Grain panels are 96 inches X 48 inches (2438 mm X 1219 mm) or optionally oversized and are fully sanded.",
                "States Industries offer most domestic hardwood species in 96 inches X 48 inches (2438 mm X 1219 mm) counterfront, or cross grain configurations.",
                "MDF and ArmorCore: Thicknesses run from 5/32 inch to 1-1/2 inches (4 mm to 38 mm).",
                "Panels conform to ANSI/HPVA HP-1-2004 Standards for Hardwood and Decorative Plywood."
            ], 4);
            $this->addListItem("Wall Paneling:", 3);
            $this->addListItems([
                "Product: INNOVA Collection as manufactured by States Industries.",
                "Species: Oak.",
                "Panel Thickness; 1/4 inch (6 mm).",
                "Core: MDF.",
                "Finish and Color: INNOVA collection.",
                "Surface: Buck Sawn detail."
            ], 4);
            $this->addListItem("Wall Paneling:", 3);
            $this->addListItems([
                "Product: LEGACY Collection as manufactured by States Industries.",
                "Panel: LIGHTLINE 5/32 inch (4 mm)."
            ], 4);
            $this->addListItems([
                "Butterwood Birch. 1/8 inch (3 mm) groove. Orangeburg",
                "Legacy Oak. 1/8 inch (3 mm) groove. Orangeburg",
                "Aromatic Cedar. No groove.",
            ], 5);
            $this->addListItem("STATELINE 1/4 inch (6 mm).", 4);
            $this->addListItems([
                "Minnesota Birch. 1/8 inch (3 mm) groove. Orangeburg",
                "Wisconsin Birch. 1/8 inch (3 mm) groove. Orangeburg",
                "Rustic Cedar. No groove.",
                "Connecticut Oak. 1/8 inch (3 mm) groove. Orangeburg",
            ], 5);
            $this->addListItem("COASTLINE 3/8 inch (9.5 mm).", 4);
            $this->addListItems([
                "Snow White Fir. 3/8 inch (9.5 mm) Mark V.",
                "Newport Oak. 3/8 inch (9.5 mm) 8 inches (203 mm) o.c.",
                "Westport Oak. 3/8 inch (9.5 mm) 8 inches (203 mm) o.c.",
                "Natural Oak. 3/8 inch (9.5 mm) Mark V.",
            ], 5);
            $this->addListItem("BEADED 5/32", 4);
            $this->addListItems([
                "Beaded Finished Birch. Beaded 1-1/2 inches (38 mm) o.c.",
                "Beaded Finished Oak. Beaded 1-1/2 inches (38 mm) o.c.",
                "Empress Unfinished Pine. Beaded 3 inches (76 mm) o.c.",
                "Paint Grade. Mill option. Beaded 1-1/2 inches (38 mm) o.c."
            ], 5);
            $this->addListItem("BEADED 1/4", 4);
            $this->addListItems([
                "Stamford Finished Oak. Beaded 1-1/2 inches (38 mm) o.c.",
                "Stamford Unfinished Oak. Beaded 1-1/2 inches (38 mm) o.c.",
                "MDF Raw 1.5\". FSC Certified. Beaded 1-1/2 inches (38 mm) o.c.",
                "MDF Primed 1.5\". FSC Certified. Beaded 1-1/2 inches (38 mm) o.c.",
                "MDF Primed 3\". FSC Certified. Beaded 3 inches (76 mm) o.c."
            ], 5);
            $this->addListItem("AMBASSADOR 1/4 inch (6 mm)", 4);
            $this->addListItem("American Cherry. 1/4 inch (6 mm) beaded. Orangeburg", 5);
            $this->addListItem("BRUSHED", 4);
            $this->addListItem("Frosted Barnwood.", 5);

            $this->addListItem("SPECIALTY DIMENSIONAL PANEL PRODUCT", 3);
            $this->addListItems([
                "120 inches (3048 mm) Lengths:",
                "6 feet (1829 mm) or 7 feet (2134 mm) Lengths:",
                "1/4 inch (6.4 mm) and Thinner:",
                "1 inch (25.4 mm) and Thicker:"
            ], 4);

            $this->addListItem("COMPONABILITY", 2);
            $this->addListItems([
                "The following components of the scheduled wood veneered fabrications shall be provide by States Industries and not by the fabricator.",
                "Pre-cut, finished and edge banded components.",
                "Components: Provide by States Industries to the fabricator/Contractor."
            ], 3);
            $this->addListItems([
                "Carcass assemblies.",
                "Cabinet skins and backs.",
                "Wall and base cabinet end panels.",
                "Drawer boxes.",
                "Drawer fronts.",
                "Loose fixtures.",
                "Flat panel doors.",
                "Shelving Tops."
            ], 4);
            $this->addListItem("Edge Banding: Treatments shall be:", 3);
            $this->addListItems([
                "Natural veneer (unfinished, clear or color matched).",
                "PVC and polyester.",
                "3 mm wood or lumber banding.",
                "clear or woodgrain foils."
            ], 4);
            $this->addListItem("Finishes: Match panel finish scheduled for each application or area.", 3);
            $this->addListItem("Ready to Assemble Drawers: Provide by States Industries to the fabricator/Contractor.", 3);
            $this->addListItems([
                "The Componabilty program offers drawer sides in a wide variety of cores and veneers. Options from aromatic cedar to Baltic birch are available in a full range of heights and edge treatment options.",
                "Joinery; Dovetail.",
                "Joinery: Bore and dowel.",
                "Joinery: Rabbet.",
                "Finish: Clear finish is standard.",
                "Finish: Custom color drawer sides and matching color bottoms."
            ], 4);
            $this->addListItem("Machining: As required for the component.", 3);
            $this->addListItems([
                "Production cutting (Rip and crosscutting).",
                "Drilling/boring (Horizontal and vertical 8 mm).",
                "Line boring (32 mm O.C. 5 mm diameter).",
                "Horizontal drilling (Pilots, countersinks and cam locks).",
                "Grooving/notching (Dados, T-moulds, and kick plates).",
                "Contour cutting (Circles, ellipses, arches, angles to 145 degrees)."
            ], 4);

            $this->addListItem("FINISHES", 2);
            $this->addListItem("NOVA Finishes", 3);
            $this->addListItems([
                "VOC free to comply with LEED IEQ Credit 4.2 Low Emitting Materials.",
                "Finish System: UV Curable Epoxy.",
                "Finish System: UV Curable Polyester.",
                "Finish System: UV Curable Urethanes.",
                "Color Finish: Clear.",
                "Color Finish - Translucent.",
                "Color Finish - Opaque.",
                "Color Finish - Printed.",
                "Sheen: Satin.",
                "Sheen: Medium.",
                "Sheen: High.",
                "Sheen: Custom."
            ], 4);
            $this->addListItem("NOVA PEAK Color Pre-finished Panels:", 3);
            $this->addListItems([
                "Panel: Matching finishes on both sides. 1/4 inch (6 mm) MDF core panels.",
                "Panel: Matching finishes on both sides. 3/4 inch (19 mm) veneer core panels.",
                "Finish System: ultraviolet cured epoxy acrylate topcoat.",
                "Species and Grade: B whole piece faced Maple.",
                "Species and Grade: B plain sliced Golden Oak.",
                "Species and Grade: A plain sliced Cherry.",
                "Species and Grade: A plain sliced African Mahogany.",
                "Finish: Mount Mazama Maple.",
                "Finish: Diamond Peak Oak.",
                "Finish: Steens Mountain Cherry.",
                "Finish: Mount Jefferson Maple.",
                "Finish: Paulina Peak Oak.",
                "Finish: Tumalo Mountain Cherry.",
                "Finish: Mount Hood Maple.",
                "Finish: Cinnamon Butte Mahogany.",
                "Finish: Powell Butte Mahogany.",
                "Finish: Hart Mountain Cherry.",
            ], 4);
            $this->addListItem("INNOVA Finishes:", 3);
            $this->addListItems([
                "Finish: Obsidian Shadow.",
                "Finish: Silver Starlight.",
                "Finish: Umber Odyssey.",
                "Finish: Tranquil Tundra.",
                "Finish: Sienna Sunrise."
            ], 4);
            $this->addListItem("Antimicrobial Finish:", 3);
            $this->addListItems([
                "Finish System: NovaSI finish system as manufactured by Sates Industries.",
                "System: Silver nanoparticles are suspended in the actual finished 100 percent solid, ultraviolet cured epoxy acrylate. In the presence of moisture, silver ions in the finish are released. This release disrupts cellular respiration, preventing the spread of bacterial contaminants"
            ], 4);
            $this->addListItem("Enhanced Chemical Resistance Finish:", 3);
            $this->addListItems([
                "Finish System: NovaLab finish system as manufactured by States Industries.",
                "SEFA compliant laboratory grade finishes",
                "Panel finish shall comply with the Scientific Equipment and Furniture Association's 8.0 Cabinet Surface Finish Tests. These include the 8.1 Chemical Spot Test, 8.2 Hot Water Test and 8.3 Impact Test.",
                "Finish: 100% solid, ultraviolet cured acrylate. Clear finish."
            ], 4);
            $this->addListItem("FABRICATI0N - CUSTOM", 2);
            $this->addListItem("Paneling: Provide panels having the following characteristics and construction.", 3);
            $this->addListItems([
                "Core: ApplePly hardwood veneered core as manufactured by States Industries.",
                "Core: ArmorCore composite/hardwood innerply veneered core as manufactured by States Industries.",
                "Core: Veneer Core laminated core as manufactured by States Industries.",
                "Core: Composite MDF in density required as manufactured by States Industries.",
                "Core: Composite Particleboard in density required as manufactured by States Industries.",
                "Species: ________.",
                "Veneer Matching: Pleasing match.",
                "Veneer Matching: Book match.",
                "Veneer Matching: Slip match.",
                "Veneer Matching: Random match.",
                "Veneer Matching: Whole piece.",
                "Face Grade: AA grade.",
                "Face Grade: A grade.",
                "Face Grade: B grade.",
                "Face Grade: C grade.",
                "Face Grade: D grade.",
                "Face Grade: E grade.",
                "Back Grade: Grade 1.",
                "Back Grade: Grade 2.",
                "Back Grade: Grade 3.",
                "Back Grade: Grade 4.",
                "Cut: Rotary.",
                "Cut: Rift cut.",
                "Cut: Plain sliced.",
                "Cut: Quarter sliced.",
                "Finish: Unfinished.",
                "Finish Color: Pigmented.",
                "Finish Color: Clear/natural.",
                "Gloss: Satin.",
                "Gloss: Medium.",
                "Gloss: High.",
                "Gloss: Custom.",
                "Provide antimicrobial finish.",
                "Provide enhanced chemical resistance finish"
            ], 4);

            $this->addListItem("EXECUTION", 1);
            $this->addListItem("EXAMINATION", 2);
            $this->addListItems([
                "Do not begin installation until substrates have been properly prepared.",
                "If substrate preparation is the responsibility of another installer, notify Architect of unsatisfactory preparation before proceeding."
            ], 3);
            $this->addListItem("PREPARATION", 2);
            $this->addListItems([
                "Clean surfaces thoroughly prior to installation.",
                "Prepare surfaces using the methods recommended by the manufacturer for achieving the best result for the substrate under the project conditions."
            ], 3);
            $this->addListItem("INSTALLATION", 2);
            $this->addListItem("Install in accordance with manufacturer's instructions and approved submittals.", 3);
            $this->addListItem("PROTECTION", 2);
            $this->addListItems([
                "Protect installed products until completion of project.",
                "Touch-up, repair or replace damaged products before Substantial Completion."
            ], 3);

            $this->addBasicText("", true);
            $this->addBasicText("END OF SECTION", true);
        }

        public function addBasicText($text, $centered = false)
        {
            $centeredOptions = ['align' => 'center'];
            $this->section->addText($text, $this->basicFont, $centered ? $centeredOptions : []);
        }

        public function addListItem($text, $indent = 0, $type = "multilevel")
        {
            $font = array_merge($this->basicFont, ['lineHeight' => 1.5]);
            $this->section->addListItem($text, $indent, $font, $type);
        }

        public function addListItems($items, $indent = 0, $type = "multilevel")
        {
            foreach ($items as $item) {
                $this->addListItem($item, $indent, $type);
            }
        }

    } // class end
}

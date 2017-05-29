using HelmesBootcamp.Models;
using System;
using System.Data;
using System.Linq;
using System.Web.Mvc;

namespace HelmesBootcamp.Controllers
{
    public class BookingController : Controller
    {
        private BookingContext db = new BookingContext();

        //
        // GET: /Booking/
        public ActionResult Index()
        {
            return View(db.Bookings.ToList());
        }

        public ActionResult GarageList()
        {
            return View(db.Garages.ToList());
        }

        //
        // GET: /Booking/Create

        public ActionResult Create()
        {
            SelectGarage();
            SelectVehicle();

            return View();
        }

        //
        // GET: /Booking/CreateGarage
        public ActionResult CreateGarage()
        {
            return View();
        }

        //
        // GET: /Booking/Edit

        public ActionResult Edit(int? id)
        {
            if (id == null)
            {
                return RedirectToAction("Index");
            }
            try
            {
                SelectGarage();
                SelectVehicle();
                return View(db.Bookings.Find(id));
            }
            catch (Exception ex)
            {
                return View("Error", new HandleErrorInfo(ex, "BookingController", "Edit"));
            }
        }

        //
        // GET: /Booking/EditGarage

        public ActionResult EditGarage(int? id)
        {
            if (id == null)
            {
                return RedirectToAction("GarageList");
            }
            try
            {
                return View(db.Garages.Find(id));
            }
            catch (Exception ex)
            {
                return View("Error", new HandleErrorInfo(ex, "BookingController", "EditGarage"));
            }
        }

        //
        // GET: /Booking/Details
        public ActionResult Details(int? id)
        {
            if (id == null)
            {
                return RedirectToAction("Index");
            }
            try
            {
                return View(db.Bookings.Find(id));
            }
            catch (Exception ex)
            {
                return View("Error", new HandleErrorInfo(ex, "BookingController", "Details"));
            }
        }

        //
        // GET: /Booking/DeleteGarage
        public ActionResult DeleteGarage(int? id)
        {
            if (id == null)
            {
                return RedirectToAction("Index");
            }
            try
            {
                return View(db.Garages.Find(id));
            }
            catch (Exception ex)
            {
                return View("Error", new HandleErrorInfo(ex, "BookingController", "DeleteGarage"));
            }
        }

        //
        // GET: /Booking/Cancel
        public ActionResult Cancel(int? id)
        {
            if (id == null)
            {
                return RedirectToAction("Index");
            }
            try
            {
                return View(db.Bookings.Find(id));
            }
            catch (Exception ex)
            {
                return View("Error", new HandleErrorInfo(ex, "BookingController", "Cancel"));
            }
        }
        
        //
        // GET: /Booking/Reports
        public ActionResult Reports()
        {
            return View(db.Bookings.ToList());
        }

        public ActionResult CustomersBooking()
        {
            SelectGarage();
            SelectVehicle();

            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult CustomersBooking(DbBooking dbbooking)
        {
            FormValidation(dbbooking);

            SelectGarage();
            SelectVehicle();

            if (ModelState.IsValid)
            {
                db.Bookings.Add(dbbooking);
                db.SaveChanges();
                return RedirectToAction("Index");
            }

            return View(dbbooking);
        }
        //
        // POST: /Booking/Create

        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Create(DbBooking dbbooking)
        {
            FormValidation(dbbooking);

            SelectGarage();
            SelectVehicle();

            if (ModelState.IsValid)
            {
                db.Bookings.Add(dbbooking);
                db.SaveChanges();
                return RedirectToAction("Index");
            }

            return View(dbbooking);
        }

        //
        // POST: /Booking/Edit

        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Edit(DbBooking model)
        {
            DbBooking booking = db.Bookings.Where(
              x => x.Id == model.Id).SingleOrDefault();
            if (booking != null)
            {
                model.Edited = DateTime.Now;
                db.Entry(booking).CurrentValues.SetValues(model);

                db.SaveChanges();
                return RedirectToAction("Index");
            }
            return View(model);
        }

        //
        // POST: /Booking/CreateGarage

        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult CreateGarage(DbGarages dbgarage)
        {
            if (ModelState.IsValid)
            {
                db.Garages.Add(dbgarage);
                db.SaveChanges();
                return RedirectToAction("Index");
            }

            return View(dbgarage);
        }

        //
        // POST: /Booking/EditGarage

        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult EditGarage(DbGarages model)
        {
            DbGarages garage = db.Garages.Where(
              x => x.Id == model.Id).SingleOrDefault();
            if (garage != null)
            {
                db.Entry(garage).CurrentValues.SetValues(model);

                db.SaveChanges();
                return RedirectToAction("Index");
            }
            return View(model);
        }
       

        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult DeleteGarage(int id)
        {
            DbGarages garages = db.Garages.Find(id);
            if (garages != null)
            {
                garages.Deleted = DateTime.Now;
                db.Entry(garages).CurrentValues.SetValues(garages);

                db.SaveChanges();
            }
            return RedirectToAction("Index");
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Cancel(int id)
        {
            DbBooking booking = db.Bookings.Find(id);
            if (booking != null)
            {
                booking.Canceled = DateTime.Now;
                db.Entry(booking).CurrentValues.SetValues(booking);

                db.SaveChanges();
            }
            return RedirectToAction("Index");
        }

        private void FormValidation(DbBooking dbbooking)
        {
            if (ModelState.IsValidField("CustomersPhoneNumber") && dbbooking.CustomersPhoneNumber.ToString().Length < 5)
            {
                ModelState.AddModelError("CustomersPhoneNumber",
                "Customer’s phone number can only contain numbers and must have at least 5 characters");
            }
            else if (ModelState.IsValidField("StartDateTime") && dbbooking.StartDateTime < DateTime.Now)
            {
                ModelState.AddModelError("StartDateTime", "Start date and time can't be in past");
            }
            else if (ModelState.IsValidField("EndTime"))
            {
                if (dbbooking.EndTime <= dbbooking.StartDateTime.TimeOfDay)
                {
                    ModelState.AddModelError("EndTime", "End time can’t be earlier or same than Start time");
                }
                else if (dbbooking.EndTime > (dbbooking.StartDateTime.AddHours(2).TimeOfDay))
                {
                    ModelState.AddModelError("EndTime", "End time can’t be later than 2 hours from Start time.");
                }
            }
        }

        private void SelectGarage()
        {
            SelectList list = new SelectList(db.Garages.ToList().Where(x => x.Deleted == null), "Id", "GarageName");
            ViewBag.garageList = list;
        }

        private void SelectVehicle()
        {
            SelectList list = new SelectList(db.Vihecles.ToList(), "Id", "TypeOfVehicle");
            ViewBag.vehicleList = list;
        }

        protected override void Dispose(bool disposing)
        {
            db.Dispose();
            base.Dispose(disposing);
        }
    }
}
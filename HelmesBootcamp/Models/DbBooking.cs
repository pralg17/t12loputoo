using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace HelmesBootcamp.Models
{
    /// <summary>
    /// We use "Db" before car to indicat that this class is reperesantion of some table in database
    /// </summary>
    [Table("Booking")]
    public class DbBooking
    {
        [Key]
        [DatabaseGeneratedAttribute(DatabaseGeneratedOption.Identity)]
        public int Id { get; set; }

        public int DbGaragesId { get; set; }
        public int DbVehiclesId { get; set; }

        [Required]
        [Display(Name = "Booking start date and time")]
        [DataType(DataType.Date)]
        [DisplayFormat(DataFormatString = "{0:dd.MM.yyyy HH:mm}", ApplyFormatInEditMode = true)]
        public DateTime StartDateTime { get; set; }

        [Required]
        [Display(Name = "Booking end time")]
        [DataType(DataType.Date)]
        [DisplayFormat(DataFormatString = "{0:c}", ApplyFormatInEditMode = true)]
        public TimeSpan EndTime { get; set; }

        [Required]
        [Display(Name = "License plate number")]
        [MinLength(4, ErrorMessage = "Licence plate number must have 4-9 characters")]
        [MaxLength(9, ErrorMessage = "Licence plate number must have 4-9 characters")]
        [RegularExpression(@"^[A-Z0-9]+$", ErrorMessage = "Invalid License plate number")]
        public string LicensePlateNumber { get; set; }

        [Required]
        [Display(Name = "Customers phone number")]
        public int CustomersPhoneNumber { get; set; }

        [Required]
        [Display(Name = "Tyre hotel")]
        public bool TyreHotel { get; set; }

        [Display(Name = "Booking information")]
        public string Information { get; set; }

        [DataType(DataType.Date)]
        [DisplayFormat(DataFormatString = "{0:dd.MM.yyyy HH:mm}", ApplyFormatInEditMode = true)]
        public DateTime? Edited { get; set; }

        [DataType(DataType.Date)]
        [DisplayFormat(DataFormatString = "{0:dd.MM.yyyy HH:mm}", ApplyFormatInEditMode = true)]
        public DateTime? Canceled { get; set; }

        public virtual DbGarages DbGarages { get; set; }

        public virtual DbVehicles DbVehicles { get; set; }
    }
}
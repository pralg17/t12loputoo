namespace HelmesBootcamp.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class Nullablefalse : DbMigration
    {
        public override void Up()
        {
            DropForeignKey("dbo.Booking", "DbGaragesId", "dbo.Garages");
            DropForeignKey("dbo.Booking", "DbVehiclesId", "dbo.Vehicles");
            DropIndex("dbo.Booking", new[] { "DbGaragesId" });
            DropIndex("dbo.Booking", new[] { "DbVehiclesId" });
            AlterColumn("dbo.Booking", "DbGaragesId", c => c.Int(nullable: false));
            AlterColumn("dbo.Booking", "DbVehiclesId", c => c.Int(nullable: false));
            CreateIndex("dbo.Booking", "DbGaragesId");
            CreateIndex("dbo.Booking", "DbVehiclesId");
            AddForeignKey("dbo.Booking", "DbGaragesId", "dbo.Garages", "Id", cascadeDelete: true);
            AddForeignKey("dbo.Booking", "DbVehiclesId", "dbo.Vehicles", "Id", cascadeDelete: true);
        }
        
        public override void Down()
        {
            DropForeignKey("dbo.Booking", "DbVehiclesId", "dbo.Vehicles");
            DropForeignKey("dbo.Booking", "DbGaragesId", "dbo.Garages");
            DropIndex("dbo.Booking", new[] { "DbVehiclesId" });
            DropIndex("dbo.Booking", new[] { "DbGaragesId" });
            AlterColumn("dbo.Booking", "DbVehiclesId", c => c.Int());
            AlterColumn("dbo.Booking", "DbGaragesId", c => c.Int());
            CreateIndex("dbo.Booking", "DbVehiclesId");
            CreateIndex("dbo.Booking", "DbGaragesId");
            AddForeignKey("dbo.Booking", "DbVehiclesId", "dbo.Vehicles", "Id");
            AddForeignKey("dbo.Booking", "DbGaragesId", "dbo.Garages", "Id");
        }
    }
}
